import { router, useFocusEffect } from "expo-router";
import { useCallback, useState } from "react";
import {
  ActivityIndicator,
  Alert,
  FlatList,
  Modal,
  ScrollView,
  Pressable,
  SafeAreaView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

import {
  Category,
  ResourceItem,
  ResourceType,
  createResource,
  deleteResource,
  getCategories,
  getCategoryId,
  getResourceId,
  getResourceTypeId,
  getResourceTypes,
  getResources,
  isUnauthorizedError,
  updateResource,
} from "../../lib/api";
import { canWrite, canAddResource } from "../../lib/session";

export default function ResourcesScreen() {
  const [items, setItems] = useState<ResourceItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [modalVisible, setModalVisible] = useState(false);
  const [categoryPickerVisible, setCategoryPickerVisible] = useState(false);
  const [typePickerVisible, setTypePickerVisible] = useState(false);
  const [editItem, setEditItem] = useState<ResourceItem | null>(null);
  const [categories, setCategories] = useState<Category[]>([]);
  const [types, setTypes] = useState<ResourceType[]>([]);
  const [formName, setFormName] = useState("");
  const [formDescription, setFormDescription] = useState("");
  const [selectedCategoryId, setSelectedCategoryId] = useState<number | null>(null);
  const [selectedTypeId, setSelectedTypeId] = useState<number | null>(null);
  const [saving, setSaving] = useState(false);
  const isManager = canWrite();
  const canAdd = canAddResource();

  async function loadResources() {
    try {
      setLoading(true);
      const [resources, categoriesData, typesData] = await Promise.all([
        getResources(),
        getCategories(),
        getResourceTypes(),
      ]);
      setItems(resources);
      setCategories(categoriesData);
      setTypes(typesData);
    } catch (error) {
      if (!isUnauthorizedError(error)) {
        Alert.alert("Erreur", (error as Error).message);
      }
    } finally {
      setLoading(false);
    }
  }

  function openCreate() {
    setEditItem(null);
    setFormName("");
    setFormDescription("");
    setSelectedCategoryId(null);
    setSelectedTypeId(null);
    setModalVisible(true);
  }

  function openEdit(item: ResourceItem) {
    setEditItem(item);
    setFormName(item.name_ressource);
    setFormDescription(item.description ?? "");
    setSelectedCategoryId(item.category_id ?? item.id_cat ?? null);
    setSelectedTypeId(item.type_id ?? item.id_typeressource ?? null);
    setModalVisible(true);
  }

  async function handleSave() {
    const name = formName.trim();
    const description = formDescription.trim();
    const categoryId = Number(selectedCategoryId ?? 0);
    const typeId = Number(selectedTypeId ?? 0);

    if (!name) return;
    if (!Number.isInteger(categoryId) || categoryId <= 0) {
      Alert.alert("Categorie manquante", "Choisis une categorie dans la liste.");
      return;
    }
    if (!Number.isInteger(typeId) || typeId <= 0) {
      Alert.alert("Type manquant", "Choisis un type dans la liste.");
      return;
    }

    const payload = {
      name_ressource: name,
      description,
      category_id: categoryId,
      type_id: typeId,
      id_cat: categoryId,
      id_typeressource: typeId,
    };

    try {
      setSaving(true);
      if (editItem) {
        await updateResource(getResourceId(editItem), payload);
      } else {
        await createResource(payload);
      }
      await loadResources();
      setModalVisible(false);
    } catch (error) {
      Alert.alert("Erreur", (error as Error).message);
    } finally {
      setSaving(false);
    }
  }

  function confirmDelete(item: ResourceItem) {
    Alert.alert(
      "Supprimer",
      `Supprimer "${item.name_ressource}" ?`,
      [
        { text: "Annuler", style: "cancel" },
        {
          text: "Supprimer",
          style: "destructive",
          onPress: async () => {
            try {
              await deleteResource(getResourceId(item));
              await loadResources();
            } catch (error) {
              Alert.alert("Erreur", (error as Error).message);
            }
          },
        },
      ]
    );
  }

  useFocusEffect(useCallback(() => { loadResources(); }, []));

  const selectedCategory = categories.find((c) => getCategoryId(c) === selectedCategoryId);
  const selectedType = types.find((t) => getResourceTypeId(t) === selectedTypeId);

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.title}>Ressources</Text>
        {canAdd && (
          <Pressable style={styles.addBtn} onPress={openCreate}>
            <Text style={styles.addBtnText}>+ Ajouter</Text>
          </Pressable>
        )}
      </View>

      {loading ? (
        <ActivityIndicator size="large" style={{ marginTop: 40 }} />
      ) : (
        <FlatList
          data={items}
          keyExtractor={(item) => String(getResourceId(item))}
          onRefresh={loadResources}
          refreshing={loading}
          renderItem={({ item }) => (
            <View style={styles.card}>
              <Text style={styles.cardTitle}>{item.name_ressource}</Text>
              <View style={styles.cardActions}>
                <Pressable
                  onPress={() =>
                    router.push({
                      pathname: "/resource/[id]",
                      params: { id: String(getResourceId(item)) },
                    })
                  }
                >
                  <Text style={styles.viewBtn}>Voir</Text>
                </Pressable>
                {isManager && (
                  <>
                  <Pressable onPress={() => openEdit(item)}>
                    <Text style={styles.editBtn}>Modifier</Text>
                  </Pressable>
                  <Pressable onPress={() => confirmDelete(item)}>
                    <Text style={styles.deleteBtn}>Supprimer</Text>
                  </Pressable>
                  </>
                )}
              </View>
            </View>
          )}
          ListEmptyComponent={<Text style={styles.empty}>Aucune ressource</Text>}
        />
      )}

      <Modal visible={modalVisible} transparent animationType="fade" onRequestClose={() => setModalVisible(false)}>
        <View style={styles.overlay}>
          <View style={styles.modal}>
            <Text style={styles.modalTitle}>{editItem ? "Modifier la ressource" : "Nouvelle ressource"}</Text>
            <TextInput
              style={styles.modalInput}
              placeholder="Nom de la ressource"
              value={formName}
              onChangeText={setFormName}
              autoFocus
            />
            <TextInput
              style={[styles.modalInput, styles.modalTextArea]}
              placeholder="Description (optionnel)"
              value={formDescription}
              onChangeText={setFormDescription}
              multiline
              numberOfLines={3}
            />
            <Pressable style={styles.modalInput} onPress={() => setCategoryPickerVisible(true)}>
              <Text style={selectedCategory ? styles.pickerValue : styles.pickerPlaceholder}>
                {selectedCategory ? selectedCategory.name_cat : "Choisir une categorie"}
              </Text>
            </Pressable>
            <Pressable style={styles.modalInput} onPress={() => setTypePickerVisible(true)}>
              <Text style={selectedType ? styles.pickerValue : styles.pickerPlaceholder}>
                {selectedType ? selectedType.name_typeressource : "Choisir un type"}
              </Text>
            </Pressable>
            <Text style={styles.modalHelp}>Categorie et type sont choisis depuis la base de donnees.</Text>
            <View style={styles.modalActions}>
              <Pressable style={styles.cancelBtn} onPress={() => setModalVisible(false)}>
                <Text style={styles.cancelBtnText}>Annuler</Text>
              </Pressable>
              <Pressable style={styles.saveBtn} onPress={handleSave} disabled={saving}>
                {saving ? <ActivityIndicator color="#fff" /> : <Text style={styles.saveBtnText}>Enregistrer</Text>}
              </Pressable>
            </View>
          </View>
        </View>
      </Modal>

      <Modal
        visible={categoryPickerVisible}
        transparent
        animationType="fade"
        onRequestClose={() => setCategoryPickerVisible(false)}
      >
        <View style={styles.overlay}>
          <View style={styles.modal}>
            <Text style={styles.modalTitle}>Choisir une categorie</Text>
            <ScrollView style={styles.pickerList}>
              {categories.map((category) => {
                const id = getCategoryId(category);
                const selected = id === selectedCategoryId;

                return (
                  <Pressable
                    key={String(id)}
                    style={[styles.pickerItem, selected && styles.pickerItemSelected]}
                    onPress={() => {
                      setSelectedCategoryId(id);
                      setCategoryPickerVisible(false);
                    }}
                  >
                    <Text style={styles.pickerItemText}>{category.name_cat}</Text>
                  </Pressable>
                );
              })}
              {categories.length === 0 && <Text style={styles.empty}>Aucune categorie disponible</Text>}
            </ScrollView>
            <View style={styles.modalActions}>
              <Pressable style={styles.cancelBtn} onPress={() => setCategoryPickerVisible(false)}>
                <Text style={styles.cancelBtnText}>Fermer</Text>
              </Pressable>
            </View>
          </View>
        </View>
      </Modal>

      <Modal
        visible={typePickerVisible}
        transparent
        animationType="fade"
        onRequestClose={() => setTypePickerVisible(false)}
      >
        <View style={styles.overlay}>
          <View style={styles.modal}>
            <Text style={styles.modalTitle}>Choisir un type</Text>
            <ScrollView style={styles.pickerList}>
              {types.map((type) => {
                const id = getResourceTypeId(type);
                const selected = id === selectedTypeId;

                return (
                  <Pressable
                    key={String(id)}
                    style={[styles.pickerItem, selected && styles.pickerItemSelected]}
                    onPress={() => {
                      setSelectedTypeId(id);
                      setTypePickerVisible(false);
                    }}
                  >
                    <Text style={styles.pickerItemText}>{type.name_typeressource}</Text>
                  </Pressable>
                );
              })}
              {types.length === 0 && <Text style={styles.empty}>Aucun type disponible</Text>}
            </ScrollView>
            <View style={styles.modalActions}>
              <Pressable style={styles.cancelBtn} onPress={() => setTypePickerVisible(false)}>
                <Text style={styles.cancelBtnText}>Fermer</Text>
              </Pressable>
            </View>
          </View>
        </View>
      </Modal>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#f7fbfa", padding: 16 },
  header: { flexDirection: "row", alignItems: "center", justifyContent: "space-between", marginBottom: 12 },
  title: { fontSize: 26, fontWeight: "700", color: "#0d3b2e" },
  addBtn: { backgroundColor: "#0e9f6e", borderRadius: 8, paddingHorizontal: 14, paddingVertical: 8 },
  addBtnText: { color: "#fff", fontWeight: "700" },
  card: { backgroundColor: "#fff", borderRadius: 12, borderWidth: 1, borderColor: "#dbe7e2", padding: 14, marginBottom: 8 },
  cardTitle: { fontSize: 16, color: "#1d2f29", fontWeight: "600", flex: 1 },
  cardActions: { flexDirection: "row", gap: 16, marginTop: 8 },
  viewBtn: { color: "#2b6cb0", fontWeight: "600" },
  editBtn: { color: "#0e9f6e", fontWeight: "600" },
  deleteBtn: { color: "#d93c3c", fontWeight: "600" },
  empty: { textAlign: "center", marginTop: 30, color: "#647973" },
  overlay: { flex: 1, backgroundColor: "rgba(0,0,0,0.4)", justifyContent: "center", padding: 24 },
  modal: { backgroundColor: "#fff", borderRadius: 16, padding: 20, gap: 12 },
  modalTitle: { fontSize: 18, fontWeight: "700", color: "#0d3b2e" },
  modalHelp: { color: "#647973", fontSize: 12, marginTop: -4 },
  modalInput: { borderWidth: 1, borderColor: "#ccddd7", borderRadius: 10, padding: 12, fontSize: 15 },
  modalTextArea: { minHeight: 84, textAlignVertical: "top" },
  pickerPlaceholder: { color: "#8aa19b", fontSize: 15 },
  pickerValue: { color: "#1d2f29", fontSize: 15 },
  pickerList: { maxHeight: 260 },
  pickerItem: { paddingVertical: 12, borderBottomWidth: 1, borderBottomColor: "#e8f0ed" },
  pickerItemSelected: { backgroundColor: "#eef8f4" },
  pickerItemText: { color: "#1d2f29", fontSize: 15 },
  modalActions: { flexDirection: "row", gap: 10, justifyContent: "flex-end" },
  cancelBtn: { backgroundColor: "#e8f0ed", borderRadius: 8, paddingHorizontal: 16, paddingVertical: 10 },
  cancelBtnText: { color: "#0d3b2e", fontWeight: "600" },
  saveBtn: { backgroundColor: "#0e9f6e", borderRadius: 8, paddingHorizontal: 16, paddingVertical: 10 },
  saveBtnText: { color: "#fff", fontWeight: "700" },
});
