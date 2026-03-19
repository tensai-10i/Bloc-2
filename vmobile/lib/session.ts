import AsyncStorage from "@react-native-async-storage/async-storage";

const TOKEN_KEY = "vmobile_auth_token";
const USER_KEY  = "vmobile_auth_user";

export type StoredUser = {
  id: number;
  name: string;
  email: string;
  role: string;
  email_verified_at: string | null;
};

let authToken: string | null = null;
let authUser: StoredUser | null = null;

export async function hydrateToken(): Promise<void> {
  authToken = await AsyncStorage.getItem(TOKEN_KEY);
  const raw = await AsyncStorage.getItem(USER_KEY);
  authUser = raw ? (JSON.parse(raw) as StoredUser) : null;
}

export async function setToken(token: string | null): Promise<void> {
  authToken = token;
  if (token) {
    await AsyncStorage.setItem(TOKEN_KEY, token);
  } else {
    await AsyncStorage.removeItem(TOKEN_KEY);
  }
}

export async function setUser(user: StoredUser | null): Promise<void> {
  authUser = user;
  if (user) {
    await AsyncStorage.setItem(USER_KEY, JSON.stringify(user));
  } else {
    await AsyncStorage.removeItem(USER_KEY);
  }
}

export function getToken(): string | null {
  return authToken;
}

export function getUser(): StoredUser | null {
  return authUser;
}

/** super_admin, admin et moderateur peuvent créer/modifier/supprimer. */
export function canWrite(): boolean {
  const role = authUser?.role ?? "";
  return ["super_admin", "superadmin", "admin", "moderateur", "moderator"].includes(role);
}

export function isAdminOrSuperAdmin(): boolean {
  const role = authUser?.role ?? "";
  return role === "admin" || role === "super_admin" || role === "superadmin";
}

export async function clearToken(): Promise<void> {
  authToken = null;
  authUser = null;
  await AsyncStorage.removeItem(TOKEN_KEY);
  await AsyncStorage.removeItem(USER_KEY);
}
