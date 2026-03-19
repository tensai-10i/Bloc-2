import { router, useFocusEffect } from "expo-router";
import { useCallback, useState } from "react";
import { ActivityIndicator, Alert, Pressable, SafeAreaView, ScrollView, StyleSheet, Text, View } from "react-native";

import { isUnauthorizedError, me, logout, resendVerificationEmail } from "../../lib/api";
import { clearToken, getToken } from "../../lib/session";

const ROLE_LABELS: Record<string, string> = {
  super_admin: "Super Admin",
  admin: "Admin",
  moderateur: "Moderateur",
  user: "Utilisateur",
};

const ROLE_COLORS: Record<string, string> = {
  super_admin: "#7c3aed",
  admin: "#0e9f6e",
  moderateur: "#d97706",
  user: "#64748b",
};

export default function ProfileScreen() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [loading, setLoading] = useState(true);
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [role, setRole] = useState("");
  const [emailVerifiedAt, setEmailVerifiedAt] = useState<string | null>(null);
  const [verifying, setVerifying] = useState(false);

  async function loadMe() {
    const token = getToken();
    if (!token) {
      setIsLoggedIn(false);
      setLoading(false);
      return;
    }
    try {
      setLoading(true);
      const user = await me();
      setName(user.name);
      setEmail(user.email);
      setIsLoggedIn(true);
      setRole(user.role ?? "");
      setEmailVerifiedAt(user.email_verified_at ?? null);
    } catch (error) {
      setIsLoggedIn(false);
      if (!isUnauthorizedError(error)) {
        Alert.alert("Erreur", (error as Error).message);
      }
    } finally {
      setLoading(false);
    }
  }

  async function handleLogout() {
    try {
      await logout();
    } catch {
      // Clear local token even if API logout fails.
    } finally {
      await clearToken();
      setIsLoggedIn(false);
      setName("");
      setEmail("");
      setRole("");
      setEmailVerifiedAt(null);
    }
  }

  async function handleVerifyEmail() {
    try {
      setVerifying(true);
      await resendVerificationEmail();
      Alert.alert("Verification email", "Email de verification envoye.");
    } catch (error) {
      Alert.alert("Erreur", (error as Error).message);
    } finally {
      setVerifying(false);
    }
  }

  useFocusEffect(
    useCallback(() => {
      loadMe();
    }, [])
  );

  if (loading) {
    return (
      <SafeAreaView style={styles.center}>
        <ActivityIndicator size="large" />
      </SafeAreaView>
    );
  }

  if (!isLoggedIn) {
    return (
      <SafeAreaView style={styles.container}>
        <View style={styles.guestBox}>
          <Text style={styles.title}>Mon profil</Text>
          <Text style={styles.guestText}>
            Connecte-toi pour acceder a ton profil.
          </Text>
          <Pressable style={styles.loginButton} onPress={() => router.push("/auth/login")}>
            <Text style={styles.loginButtonText}>Se connecter</Text>
          </Pressable>
          <Pressable style={styles.registerButton} onPress={() => router.push("/auth/register")}>
            <Text style={styles.registerButtonText}>Creer un compte</Text>
          </Pressable>
        </View>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <ScrollView showsVerticalScrollIndicator={false}>
        <Text style={styles.title}>Mon profil</Text>

        {/* Email verification warning */}
        {!emailVerifiedAt && (
          <View style={styles.warningBox}>
            <Text style={styles.warningText}>
              ⚠️  Ton email n'est pas verifie. Verifie ta boite mail.
            </Text>
            <Pressable style={styles.verifyButton} onPress={handleVerifyEmail} disabled={verifying}>
              {verifying ? (
                <ActivityIndicator color="#fff" />
              ) : (
                <Text style={styles.verifyButtonText}>Verifier</Text>
              )}
            </Pressable>
          </View>
        )}

        {/* Role badge */}
        {role ? (
          <View style={[styles.roleBadge, { backgroundColor: ROLE_COLORS[role] ?? "#64748b" }]}>
            <Text style={styles.roleText}>{ROLE_LABELS[role] ?? role}</Text>
          </View>
        ) : null}

        <View style={styles.infoBox}>
          <Text style={styles.infoLabel}>Nom</Text>
          <Text style={styles.infoValue}>{name}</Text>
        </View>
        <View style={styles.infoBox}>
          <Text style={styles.infoLabel}>Email</Text>
          <Text style={styles.infoValue}>{email}</Text>
        </View>
        <View style={styles.infoBox}>
          <Text style={styles.infoLabel}>Email verifie</Text>
          <Text style={[styles.infoValue, { color: emailVerifiedAt ? "#0e9f6e" : "#d93c3c" }]}>
            {emailVerifiedAt ? "Oui ✓" : "Non ✗"}
          </Text>
        </View>

        <Pressable style={styles.logoutButton} onPress={handleLogout}>
          <Text style={styles.logoutButtonText}>Se deconnecter</Text>
        </Pressable>
      </ScrollView>
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
  },
  guestBox: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    gap: 14,
    paddingHorizontal: 24,
  },
  title: {
    fontSize: 26,
    fontWeight: "700",
    color: "#0d3b2e",
    marginBottom: 10,
  },
  guestText: {
    fontSize: 15,
    color: "#4b6b60",
    textAlign: "center",
    marginBottom: 6,
  },
  warningBox: {
    backgroundColor: "#fff7ed",
    borderWidth: 1,
    borderColor: "#fed7aa",
    borderRadius: 10,
    padding: 12,
    marginBottom: 12,
  },
  warningText: {
    color: "#92400e",
    fontSize: 14,
  },
  verifyButton: {
    marginTop: 10,
    alignSelf: "flex-start",
    backgroundColor: "#f59e0b",
    borderRadius: 8,
    paddingHorizontal: 14,
    paddingVertical: 8,
  },
  verifyButtonText: {
    color: "#fff",
    fontWeight: "700",
  },
  roleBadge: {
    alignSelf: "flex-start",
    borderRadius: 20,
    paddingHorizontal: 14,
    paddingVertical: 6,
    marginBottom: 16,
  },
  roleText: {
    color: "#fff",
    fontWeight: "700",
    fontSize: 13,
    letterSpacing: 0.5,
  },
  infoBox: {
    backgroundColor: "#fff",
    borderRadius: 10,
    borderWidth: 1,
    borderColor: "#dbe7e2",
    padding: 14,
    marginBottom: 10,
  },
  infoLabel: {
    fontSize: 12,
    color: "#64748b",
    marginBottom: 4,
    textTransform: "uppercase",
    letterSpacing: 0.5,
  },
  infoValue: {
    fontSize: 16,
    color: "#1d2f29",
    fontWeight: "600",
  },
  loginButton: {
    width: "100%",
    backgroundColor: "#0e9f6e",
    borderRadius: 10,
    alignItems: "center",
    paddingVertical: 13,
  },
  loginButtonText: {
    color: "#fff",
    fontWeight: "700",
    fontSize: 15,
  },
  registerButton: {
    width: "100%",
    backgroundColor: "#fff",
    borderRadius: 10,
    alignItems: "center",
    paddingVertical: 13,
    borderWidth: 1.5,
    borderColor: "#0e9f6e",
  },
  registerButtonText: {
    color: "#0e9f6e",
    fontWeight: "700",
    fontSize: 15,
  },
  logoutButton: {
    marginTop: 20,
    backgroundColor: "#d93c3c",
    borderRadius: 10,
    alignItems: "center",
    paddingVertical: 12,
  },
  logoutButtonText: {
    color: "#fff",
    fontWeight: "700",
  },
});
