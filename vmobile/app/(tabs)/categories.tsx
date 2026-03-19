import { useFocusEffect } from "expo-router";
import { useCallback, useState } from "react";
import {
  ActivityIndicator,
  Alert,
  FlatList,
  Modal,
  Pressable,
  SafeAreaView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

import {
  Category,
  createCategory,
  deleteCategory,
  getCategories,
  isUnauthorizedError,
  updateCategory,
} from "../../lib/api";
import { canWrite } from "../../lib/session";

export default function CategoriesScreen() {
  const [items, setItems] = useState<Category[]>([]);
  const [loading, setLoading] = useState(true);
  const [modalVisible, setModalVisible] = useState(false);
  const [editItem, setEditItem] = useState<Category | null>(null);
  const [formName, setFormName] = useState("");
  const [saving, setSaving] = useState(false);
  const isManager = canWrite();

  async function loadCategories() {
    try {
      setLoading(true);
      setItems(await getCategories());
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
    setModalVisible(true);
  }

  function openEdit(item: Category) {
    setEditItem(item);
    setFormName(item.name_cat);
    setModalVisible(true);
  }

  async function handleSave() {
    const name = formName.trim();
    if (!name) return;
    try {
      setSaving(true);
      if (editItem) {
        await updateCategory(editItem.id, name);
      } else {
        await createCategory(name);
      }
      await loadCategories();
      setModalVisible(false);
    } catch (error) {
      Alert.alert("Erreur", (error as Error).message);
    } finally {
      setSaving(false);
    }
  }

  function confirmDelete(item: Category) {
    Alert.alert(
      "Supprimer",
      `Supprimer "${item.name_cat}" ?`,
      [
        { text: "Annuler", style: "cancel" },
        {
          text: "Supprimer",
          style: "destructive",
          onPress: async () => {
            try {
              await deleteCategory(item.id);
              await loadCategories();
            } catch (error) {
              Alert.alert("Erreur", (error as Error).message);
            }
          },
        },
      ]
    );
  }

  useFocusEffect(useCallback(() => { loadCategories(); }, []));

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.title}>Categories</Text>
        {isManager && (
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
          keyExtractor={(item) => String(item.id)}
          onRefresh={loadCategories}
          refreshing={loading}
          renderItem={({ item }) => (
            <View style={styles.card}>
              <Text style={styles.cardTitle}>{item.name_cat}</Text>
              {isManager && (
                <View style={styles.cardActions}>
                  <Pressable onPress={() => openEdit(item)}>
                    <Text style={styles.editBtn}>Modifier</Text>
                  </Pressable>
                  <Pressable onPress={() => confirmDelete(item)}>
                    <Text style={styles.deleteBtn}>Supprimer</Text>
                  </Pressable>
                </View>
              )}
            </View>
          )}
          ListEmptyComponent={<Text style={styles.empty}>Aucune categorie</Text>}
        />
      )}

      <Modal visible={modalVisible} transparent animationType="fade" onRequestClose={() => setModalVisible(false)}>
        <View style={styles.overlay}>
          <View style={styles.modal}>
            <Text style={styles.modalTitle}>{editItem ? "Modifier la categorie" : "Nouvelle categorie"}</Text>
            <TextInput
              style={styles.modalInput}
              placeholder="Nom de la categorie"
              value={formName}
              onChangeText={setFormName}
              autoFocus
            />
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
  cardTitle: { fontSize: 16, color: "#1d2f29", fontWeight: "600" },
  cardActions: { flexDirection: "row", gap: 16, marginTop: 8 },
  editBtn: { color: "#0e9f6e", fontWeight: "600" },
  deleteBtn: { color: "#d93c3c", fontWeight: "600" },
  empty: { textAlign: "center", marginTop: 30, color: "#647973" },
  overlay: { flex: 1, backgroundColor: "rgba(0,0,0,0.4)", justifyContent: "center", padding: 24 },
  modal: { backgroundColor: "#fff", borderRadius: 16, padding: 20, gap: 12 },
  modalTitle: { fontSize: 18, fontWeight: "700", color: "#0d3b2e" },
  modalInput: { borderWidth: 1, borderColor: "#ccddd7", borderRadius: 10, padding: 12, fontSize: 15 },
  modalActions: { flexDirection: "row", gap: 10, justifyContent: "flex-end" },
  cancelBtn: { backgroundColor: "#e8f0ed", borderRadius: 8, paddingHorizontal: 16, paddingVertical: 10 },
  cancelBtnText: { color: "#0d3b2e", fontWeight: "600" },
  saveBtn: { backgroundColor: "#0e9f6e", borderRadius: 8, paddingHorizontal: 16, paddingVertical: 10 },
  saveBtnText: { color: "#fff", fontWeight: "700" },
});
