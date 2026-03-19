import { Tabs, useFocusEffect } from "expo-router";
import { useCallback, useState } from "react";
import { Ionicons } from "@expo/vector-icons";

import { me } from "../../lib/api";
import { getToken, setUser } from "../../lib/session";

export default function TabsLayout() {
  const [canManage, setCanManage] = useState(false);

  useFocusEffect(
    useCallback(() => {
      let active = true;

      const refreshRole = async () => {
        if (!getToken()) {
          if (active) setCanManage(false);
          return;
        }

        try {
          const user = await me();
          await setUser(user);
          if (active) setCanManage(user.role === "admin" || user.role === "super_admin");
        } catch {
          if (active) setCanManage(false);
        }
      };

      refreshRole();

      return () => {
        active = false;
      };
    }, [])
  );

  return (
    <Tabs
      initialRouteName="resources"
      screenOptions={{
        headerStyle: { backgroundColor: "#f2f8f7" },
        tabBarActiveTintColor: "#0e9f6e",
      }}
    >
      <Tabs.Screen
        name="categories"
        options={{
          title: "Categories",
          tabBarIcon: ({ color, size }) => <Ionicons name="grid-outline" size={size} color={color} />,
        }}
      />
      <Tabs.Screen
        name="resources"
        options={{
          title: "Ressources",
          tabBarIcon: ({ color, size }) => <Ionicons name="book-outline" size={size} color={color} />,
        }}
      />
      <Tabs.Screen
        name="role-management"
        options={{
          title: "Roles",
          tabBarButton: canManage ? undefined : () => null,
          tabBarItemStyle: canManage ? undefined : { display: "none" },
          tabBarIcon: ({ color, size }) => <Ionicons name="people-outline" size={size} color={color} />,
        }}
      />
      <Tabs.Screen
        name="moderation"
        options={{
          title: "Moderation",
          tabBarButton: canManage ? undefined : () => null,
          tabBarItemStyle: canManage ? undefined : { display: "none" },
          tabBarIcon: ({ color, size }) => <Ionicons name="shield-checkmark-outline" size={size} color={color} />,
        }}
      />
      <Tabs.Screen
        name="profile"
        options={{
          title: "Profil",
          tabBarIcon: ({ color, size }) => <Ionicons name="person-outline" size={size} color={color} />,
        }}
      />
    </Tabs>
  );
}
