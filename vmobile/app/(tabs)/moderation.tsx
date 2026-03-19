import { useFocusEffect } from "expo-router";
import { useCallback, useState } from "react";
import { ActivityIndicator, Alert, FlatList, Pressable, SafeAreaView, StyleSheet, Text, View } from "react-native";

import { ResourceItem, getResources, isUnauthorizedError, me, moderateResource } from "../../lib/api";
import { getToken, setUser } from "../../lib/session";

export default function ModerationScreen() {
  const [canAccess, setCanAccess] = useState(false);
  const [loading, setLoading] = useState(true);
  const [savingId, setSavingId] = useState<number | null>(null);
  const [items, setItems] = useState<ResourceItem[]>([]);

  async function loadData() {
    if (!getToken()) {
      setCanAccess(false);
      setLoading(false);
      return;
    }

    try {
      setLoading(true);
      const user = await me();
      await setUser(user);

      const allowed = user.role === "admin" || user.role === "super_admin";
      setCanAccess(allowed);

      if (!allowed) {
        setItems([]);
        return;
      }

      setItems(await getResources());
    } catch (error) {
      if (!isUnauthorizedError(error)) {
        Alert.alert("Erreur", (error as Error).message);
      }
      setCanAccess(false);
    } finally {
      setLoading(false);
    }
  }

  useFocusEffect(
    useCallback(() => {
      loadData();
    }, [])
  );

  async function handleModeration(item: ResourceItem, action: "approve" | "reject") {
    try {
      setSavingId(item.id);
      const response = await moderateResource(item.id, action);
      Alert.alert("Moderation", response.message);

      if (action === "reject") {
        setItems((prev) => prev.filter((r) => r.id !== item.id));
      }
    } catch (error) {
      Alert.alert("Erreur", (error as Error).message);
    } finally {
      setSavingId(null);
    }
  }

  if (!canAccess) {
    if (loading) {
      return (
        <SafeAreaView style={styles.center}>
          <ActivityIndicator size="large" />
        </SafeAreaView>
      );
    }

    return (
      <SafeAreaView style={styles.center}>
        <Text style={styles.lockTitle}>Acces refuse</Text>
        <Text style={styles.lockText}>La moderation est reservee aux comptes admin et super_admin.</Text>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.title}>Moderation</Text>
      <Text style={styles.subtitle}>Moderation connectee a l'API</Text>

      {loading ? (
        <ActivityIndicator size="large" style={{ marginTop: 30 }} />
      ) : (
        <FlatList
          data={items}
          keyExtractor={(item) => String(item.id)}
          onRefresh={loadData}
          refreshing={loading}
          ListEmptyComponent={<Text style={styles.note}>Aucune ressource a moderer.</Text>}
          renderItem={({ item }) => (
            <View style={styles.card}>
              <Text style={styles.itemTitle}>{item.name_ressource}</Text>
              <Text style={styles.status}>ID: {item.id}</Text>

              <View style={styles.actions}>
                <Pressable
                  style={styles.approveBtn}
                  onPress={() => handleModeration(item, "approve")}
                  disabled={savingId === item.id}
                >
                  <Text style={styles.approveText}>Approuver</Text>
                </Pressable>
                <Pressable
                  style={styles.rejectBtn}
                  onPress={() => handleModeration(item, "reject")}
                  disabled={savingId === item.id}
                >
                  {savingId === item.id ? (
                    <ActivityIndicator color="#d93c3c" />
                  ) : (
                    <Text style={styles.rejectText}>Rejeter</Text>
                  )}
                </Pressable>
              </View>
            </View>
          )}
        />
      )}
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#f7fbfa",
    padding: 16,
  },
  center: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: "#f7fbfa",
    padding: 24,
  },
  lockTitle: {
    fontSize: 24,
    fontWeight: "700",
    color: "#0d3b2e",
    marginBottom: 8,
  },
  lockText: {
    textAlign: "center",
    color: "#647973",
    fontSize: 15,
  },
  title: {
    fontSize: 26,
    fontWeight: "700",
    color: "#0d3b2e",
  },
  subtitle: {
    marginTop: 4,
    marginBottom: 12,
    color: "#607570",
  },
  card: {
    backgroundColor: "#fff",
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#dbe7e2",
    padding: 14,
    marginBottom: 10,
  },
  itemTitle: {
    fontSize: 16,
    fontWeight: "700",
    color: "#1d2f29",
  },
  status: {
    marginTop: 4,
    color: "#546d65",
  },
  actions: {
    flexDirection: "row",
    gap: 10,
    marginTop: 10,
  },
  approveBtn: {
    flex: 1,
    backgroundColor: "#e6f7ef",
    borderWidth: 1,
    borderColor: "#0e9f6e",
    borderRadius: 10,
    alignItems: "center",
    paddingVertical: 10,
  },
  approveText: {
    color: "#0e9f6e",
    fontWeight: "700",
  },
  rejectBtn: {
    flex: 1,
    backgroundColor: "#feeeee",
    borderWidth: 1,
    borderColor: "#d93c3c",
    borderRadius: 10,
    alignItems: "center",
    paddingVertical: 10,
  },
  rejectText: {
    color: "#d93c3c",
    fontWeight: "700",
  },
  note: {
    marginTop: 8,
    color: "#647973",
    fontSize: 13,
    textAlign: "center",
  },
});
