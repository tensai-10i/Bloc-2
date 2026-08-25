import { useEffect, useRef, useState } from "react";
import { router, useLocalSearchParams } from "expo-router";
import {
  ActivityIndicator,
  Alert,
  KeyboardAvoidingView,
  Platform,
  Pressable,
  SafeAreaView,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

import {
  Comment,
  ResourceItem,
  getResourceById,
  getResourceComments,
  postComment,
  isUnauthorizedError,
} from "../../lib/api";

export default function ResourceDetailScreen() {
  const params = useLocalSearchParams<{ id?: string | string[] }>();
  const rawId = Array.isArray(params.id) ? params.id[0] : params.id;
  const resourceId = Number(rawId ?? 0);

  const [loading, setLoading] = useState(true);
  const [resource, setResource] = useState<ResourceItem | null>(null);
  const [comments, setComments] = useState<Comment[]>([]);
  const [newComment, setNewComment] = useState("");
  const [submitting, setSubmitting] = useState(false);
  const scrollRef = useRef<ScrollView>(null);

  useEffect(() => {
    let active = true;

    async function load() {
      if (!Number.isInteger(resourceId) || resourceId <= 0) {
        if (active) {
          setLoading(false);
          Alert.alert("Erreur", "Identifiant de ressource invalide.");
        }
        return;
      }

      try {
        setLoading(true);
        const [resourceData, commentsData] = await Promise.all([
          getResourceById(resourceId),
          getResourceComments(resourceId),
        ]);

        if (!active) return;
        setResource(resourceData);
        setComments(commentsData);
      } catch (error) {
        if (active && !isUnauthorizedError(error)) {
          Alert.alert("Erreur", (error as Error).message);
        }
      } finally {
        if (active) setLoading(false);
      }
    }

    load();

    return () => {
      active = false;
    };
  }, [resourceId]);

  async function handleAddComment() {
    const content = newComment.trim();
    if (!content) return;

    try {
      setSubmitting(true);
      const created = await postComment(resourceId, content);
      setComments((prev) => [...prev, created]);
      setNewComment("");
      setTimeout(() => scrollRef.current?.scrollToEnd({ animated: true }), 100);
    } catch (error) {
      if (!isUnauthorizedError(error)) {
        Alert.alert("Erreur", (error as Error).message);
      }
    } finally {
      setSubmitting(false);
    }
  }

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Pressable style={styles.backBtn} onPress={() => router.back()}>
          <Text style={styles.backBtnText}>← Retour</Text>
        </Pressable>
      </View>

      {loading ? (
        <ActivityIndicator size="large" style={{ marginTop: 40 }} />
      ) : !resource ? (
        <Text style={styles.empty}>Ressource introuvable</Text>
      ) : (
        <KeyboardAvoidingView
          style={{ flex: 1 }}
          behavior={Platform.OS === "ios" ? "padding" : "height"}
          keyboardVerticalOffset={Platform.OS === "ios" ? 0 : 24}
        >
          <ScrollView
            ref={scrollRef}
            contentContainerStyle={styles.content}
            keyboardShouldPersistTaps="handled"
          >
            <Text style={styles.title}>{resource.name_ressource}</Text>

            <View style={styles.card}>
              <Text style={styles.cardContent}>
                {resource.description?.trim() ? resource.description : "Aucune description."}
              </Text>
            </View>

            <Text style={styles.sectionTitle}>
              Commentaires ({comments.length})
            </Text>

            {comments.length === 0 ? (
              <Text style={styles.empty}>Aucun commentaire pour l'instant.</Text>
            ) : (
              comments.map((c) => (
                <View style={styles.commentCard} key={c.id}>
                  <View style={styles.commentHeader}>
                    <Text style={styles.commentAuthor}>{c.user_name}</Text>
                    <Text style={styles.commentDate}>
                      {c.created_at ? new Date(c.created_at).toLocaleDateString("fr-FR") : ""}
                    </Text>
                  </View>
                  <Text style={styles.commentContent}>{c.content}</Text>
                </View>
              ))
            )}

            {/* Champ de commentaire intégré dans le scroll */}
            <View style={styles.commentBar}>
              <TextInput
                style={styles.commentInput}
                placeholder="Ajouter un commentaire..."
                placeholderTextColor="#8fa89f"
                value={newComment}
                onChangeText={setNewComment}
                multiline
                maxLength={2000}
              />
              <Pressable
                style={[styles.sendBtn, (!newComment.trim() || submitting) && styles.sendBtnDisabled]}
                onPress={handleAddComment}
                disabled={!newComment.trim() || submitting}
              >
                <Text style={styles.sendBtnText}>{submitting ? "..." : "Envoyer"}</Text>
              </Pressable>
            </View>
          </ScrollView>
        </KeyboardAvoidingView>
      )}
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#f7fbfa" },
  header: {
    flexDirection: "row",
    alignItems: "center",
    paddingHorizontal: 16,
    paddingTop: 12,
    paddingBottom: 8,
    borderBottomWidth: 1,
    borderBottomColor: "#dbe7e2",
    backgroundColor: "#fff",
  },
  backBtn: {
    backgroundColor: "#e8f0ed",
    borderRadius: 8,
    paddingHorizontal: 14,
    paddingVertical: 8,
  },
  backBtnText: { color: "#0d3b2e", fontWeight: "600", fontSize: 15 },
  content: { padding: 16, gap: 12, paddingBottom: 40 },
  title: { fontSize: 26, fontWeight: "700", color: "#0d3b2e", marginBottom: 4 },
  card: {
    backgroundColor: "#fff",
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#dbe7e2",
    padding: 14,
  },
  cardContent: { color: "#1d2f29", fontSize: 15, lineHeight: 22 },
  sectionTitle: {
    fontSize: 18,
    fontWeight: "700",
    color: "#0d3b2e",
    marginTop: 8,
  },
  commentCard: {
    backgroundColor: "#fff",
    borderRadius: 10,
    borderWidth: 1,
    borderColor: "#dbe7e2",
    padding: 12,
    gap: 4,
  },
  commentHeader: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
  },
  commentAuthor: { fontWeight: "700", color: "#0d3b2e", fontSize: 13 },
  commentDate: { color: "#8fa89f", fontSize: 12 },
  commentContent: { color: "#1d2f29", fontSize: 14, lineHeight: 20, marginTop: 2 },
  empty: { textAlign: "center", color: "#8fa89f", fontSize: 14, paddingVertical: 8 },
  commentBar: {
    flexDirection: "row",
    alignItems: "flex-end",
    gap: 8,
    backgroundColor: "#fff",
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#dbe7e2",
    padding: 10,
    marginTop: 4,
  },
  commentInput: {
    flex: 1,
    backgroundColor: "#f1f7f4",
    borderRadius: 10,
    borderWidth: 1,
    borderColor: "#dbe7e2",
    paddingHorizontal: 12,
    paddingVertical: 8,
    fontSize: 14,
    color: "#1d2f29",
    maxHeight: 100,
  },
  sendBtn: {
    backgroundColor: "#0d3b2e",
    borderRadius: 10,
    paddingHorizontal: 16,
    paddingVertical: 10,
  },
  sendBtnDisabled: { backgroundColor: "#8fa89f" },
  sendBtnText: { color: "#fff", fontWeight: "700", fontSize: 14 },
});

