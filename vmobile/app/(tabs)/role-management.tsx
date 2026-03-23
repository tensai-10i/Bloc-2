import { useFocusEffect } from "expo-router";
import { useCallback, useState } from "react";
import { ActivityIndicator, Alert, FlatList, Pressable, SafeAreaView, StyleSheet, Text, View } from "react-native";

import { RoleName, User, getUsers, isUnauthorizedError, me, updateUserRole } from "../../lib/api";
import { getToken, setUser } from "../../lib/session";

export default function RoleManagementScreen() {
  const [canAccess, setCanAccess] = useState(false);
  const [users, setUsers] = useState<User[]>([]);
  const [loading, setLoading] = useState(true);
  const [savingUserId, setSavingUserId] = useState<number | null>(null);

  async function loadData() {
    if (!getToken()) {
      setCanAccess(false);
      setLoading(false);
      return;
    }

    try {
      setLoading(true);
      const meUser = await me();
      await setUser(meUser);

      const allowed = meUser.role === "admin" || meUser.role === "super_admin";
      setCanAccess(allowed);

      if (!allowed) {
        setUsers([]);
        return;
      }

      setUsers(await getUsers());
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

  async function handleAssignRole(userId: number, role: RoleName) {
    try {
      setSavingUserId(userId);
      const updated = await updateUserRole(userId, role);
      setUsers((prev) => prev.map((u) => (u.id === updated.id ? updated : u)));
      Alert.alert("Succes", "Role mis a jour.");
    } catch (error) {
      Alert.alert("Erreur", (error as Error).message);
    } finally {
      setSavingUserId(null);
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
        <Text style={styles.lockText}>Cette section est reservee aux comptes admin et super_admin.</Text>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.title}>Attribution des roles</Text>
      <Text style={styles.subtitle}>Tous les utilisateurs - choisis le role directement</Text>

      {loading ? (
        <ActivityIndicator size="large" style={{ marginTop: 30 }} />
      ) : (
        <FlatList
          data={users}
          keyExtractor={(item) => String(item.id)}
          onRefresh={loadData}
          refreshing={loading}
          ListEmptyComponent={<Text style={styles.empty}>Aucun utilisateur</Text>}
          renderItem={({ item }) => (
            <View style={styles.card}>
              <Text style={styles.userName}>{item.name}</Text>
              <Text style={styles.userEmail}>{item.email}</Text>
              <Text style={styles.currentRole}>Role actuel: {item.role}</Text>

              <View style={styles.buttonsRow}>
                <Pressable
                  style={styles.buttonSecondary}
                  onPress={() => handleAssignRole(item.id, "user")}
                  disabled={savingUserId === item.id}
                >
                  <Text style={styles.buttonSecondaryText}>User</Text>
                </Pressable>
                <Pressable
                  style={styles.buttonSecondary}
                  onPress={() => handleAssignRole(item.id, "moderateur")}
                  disabled={savingUserId === item.id}
                >
                  <Text style={styles.buttonSecondaryText}>Moderateur</Text>
                </Pressable>
              </View>
              <View style={styles.buttonsRow}>
                <Pressable
                  style={styles.buttonPrimary}
                  onPress={() => handleAssignRole(item.id, "admin")}
                  disabled={savingUserId === item.id}
                >
                  <Text style={styles.buttonPrimaryText}>Admin</Text>
                </Pressable>
                <Pressable
                  style={styles.buttonDanger}
                  onPress={() => handleAssignRole(item.id, "super_admin")}
                  disabled={savingUserId === item.id}
                >
                  {savingUserId === item.id ? (
                    <ActivityIndicator color="#fff" />
                  ) : (
                    <Text style={styles.buttonDangerText}>Super Admin</Text>
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
    marginBottom: 14,
    color: "#607570",
  },
  empty: {
    textAlign: "center",
    marginTop: 30,
    color: "#647973",
  },
  card: {
    backgroundColor: "#fff",
    borderWidth: 1,
    borderColor: "#dbe7e2",
    borderRadius: 12,
    padding: 14,
    gap: 10,
    marginBottom: 10,
  },
  userName: {
    fontSize: 16,
    fontWeight: "700",
    color: "#1d2f29",
  },
  userEmail: {
    color: "#607570",
  },
  currentRole: {
    color: "#425d55",
    fontWeight: "600",
  },
  buttonsRow: {
    flexDirection: "row",
    gap: 8,
  },
  buttonPrimary: {
    flex: 1,
    backgroundColor: "#0e9f6e",
    borderRadius: 10,
    paddingVertical: 12,
    alignItems: "center",
  },
  buttonPrimaryText: {
    color: "#fff",
    fontWeight: "700",
  },
  buttonSecondary: {
    flex: 1,
    backgroundColor: "#eef7f3",
    borderRadius: 10,
    paddingVertical: 12,
    alignItems: "center",
    borderWidth: 1,
    borderColor: "#0e9f6e",
  },
  buttonSecondaryText: {
    color: "#0e9f6e",
    fontWeight: "700",
  },
  buttonDanger: {
    flex: 1,
    backgroundColor: "#d93c3c",
    borderRadius: 10,
    paddingVertical: 12,
    alignItems: "center",
  },
  buttonDangerText: {
    color: "#fff",
    fontWeight: "700",
  },
});
