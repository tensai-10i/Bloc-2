import { Link, router } from "expo-router";
import { useState } from "react";
import {
  ActivityIndicator,
  Alert,
  Pressable,
  SafeAreaView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

import { login } from "../../lib/api";

export default function LoginScreen() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);

  async function handleLogin() {
    if (!email || !password) {
      Alert.alert("Champs requis", "Saisis ton email et ton mot de passe.");
      return;
    }

    try {
      setLoading(true);
      await login(email.trim(), password.trim());
      router.replace("/(tabs)/resources");
    } catch (error) {
      Alert.alert("Connexion echouee", (error as Error).message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.title}>Connexion</Text>
      <Text style={styles.subtitle}>Connecte-toi a ton API Laravel</Text>

      <TextInput
        autoCapitalize="none"
        keyboardType="email-address"
        placeholder="Email"
        style={styles.input}
        value={email}
        onChangeText={setEmail}
      />

      <TextInput
        secureTextEntry
        autoCapitalize="none"
        autoCorrect={false}
        placeholder="Mot de passe"
        style={styles.input}
        value={password}
        onChangeText={setPassword}
      />

      <Pressable style={styles.button} onPress={handleLogin} disabled={loading}>
        {loading ? <ActivityIndicator color="#fff" /> : <Text style={styles.buttonText}>Se connecter</Text>}
      </Pressable>

      <View style={styles.footer}>
        <Text>Pas de compte ? </Text>
        <Link href="/auth/register" style={styles.link}>
          S'inscrire
        </Link>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#f7fbfa",
    justifyContent: "flex-start",
    padding: 20,
    paddingTop: 56,
    gap: 12,
  },
  title: {
    fontSize: 34,
    fontWeight: "700",
    color: "#0d3b2e",
  },
  subtitle: {
    color: "#4b635b",
    marginBottom: 16,
  },
  input: {
    backgroundColor: "#fff",
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#d8e4de",
    paddingHorizontal: 14,
    paddingVertical: 12,
  },
  button: {
    backgroundColor: "#0e9f6e",
    borderRadius: 12,
    alignItems: "center",
    paddingVertical: 13,
    marginTop: 8,
  },
  buttonText: {
    color: "#fff",
    fontWeight: "700",
  },
  footer: {
    marginTop: 8,
    flexDirection: "row",
    justifyContent: "center",
  },
  link: {
    color: "#0e9f6e",
    fontWeight: "700",
  },
});
