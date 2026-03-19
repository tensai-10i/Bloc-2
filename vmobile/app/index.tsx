import { useEffect, useState } from "react";
import { Redirect } from "expo-router";
import { hydrateToken } from "../lib/session";

export default function Page() {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const bootstrapAsync = async () => {
      try {
        // Restaure le token depuis AsyncStorage
        await hydrateToken();
      } catch (error) {
        console.error("Failed to hydrate session:", error);
      } finally {
        setIsLoading(false);
      }
    };

    bootstrapAsync();
  }, []);

  if (isLoading) {
    // Afficher un splash screen pendant la restauration
    return null;
  }

  // Toujours aller à resources, peu importe l'authentification
  return <Redirect href="/(tabs)/resources" />;
}
