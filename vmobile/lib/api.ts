import { API_BASE_URL } from "./config";
import { StoredUser, clearToken, getToken, setToken, setUser } from "./session";

type RequestMethod = "GET" | "POST" | "PUT" | "DELETE";

export type User = {
  id: number;
  name: string;
  email: string;
  role: string;
  email_verified_at: string | null;
  role_id?: number;
};

export type RoleName = "user" | "moderateur" | "admin" | "super_admin";

export type Category = {
  id: number;
  id_cat?: number;
  name_cat: string;
};

export type ResourceItem = {
  id: number;
  id_ressource?: number;
  name_ressource: string;
  description?: string | null;
  category_id?: number | null;
  type_id?: number | null;
  id_cat?: number | null;
  id_typeressource?: number | null;
};

export type ResourcePayload = {
  name_ressource: string;
  description?: string;
  category_id?: number;
  type_id?: number;
  id_cat?: number;
  id_typeressource?: number;
};

export type ResourceType = {
  id: number;
  id_typeressource?: number;
  name_typeressource: string;
};

export type Comment = {
  id: number;
  content: string;
  user_name: string;
  created_at: string;
};

type ModerateResponse = {
  message: string;
  action: "approve" | "reject";
  resource?: ResourceItem;
};

type RequestOptions = {
  method?: RequestMethod;
  body?: unknown;
  withAuth?: boolean;
};

type ApiErrorBody = {
  message?: string;
  errors?: Record<string, string[]>;
};

export class ApiError extends Error {
  status: number;
  errors?: Record<string, string[]>;

  constructor(message: string, status: number, errors?: Record<string, string[]>) {
    super(message);
    this.name = "ApiError";
    this.status = status;
    this.errors = errors;
  }
}

export function isUnauthorizedError(error: unknown): error is ApiError {
  return error instanceof ApiError && error.status === 401;
}

export function getCategoryId(category: Partial<Category>): number {
  return Number(category.id ?? category.id_cat ?? 0);
}

export function getResourceId(resource: Partial<ResourceItem>): number {
  return Number(resource.id ?? resource.id_ressource ?? 0);
}

export function getResourceTypeId(type: Partial<ResourceType>): number {
  return Number(type.id ?? type.id_typeressource ?? 0);
}

function normalizeCategory(raw: Category): Category {
  const id = getCategoryId(raw);
  return {
    ...raw,
    id,
  };
}

function normalizeResource(raw: ResourceItem): ResourceItem {
  const id = getResourceId(raw);
  return {
    ...raw,
    id,
    category_id: raw.category_id ?? raw.id_cat ?? null,
    type_id: raw.type_id ?? raw.id_typeressource ?? null,
  };
}

function normalizeResourceType(raw: ResourceType): ResourceType {
  const id = getResourceTypeId(raw);
  return {
    ...raw,
    id,
  };
}

async function request<T>(path: string, options: RequestOptions = {}): Promise<T> {
  const token = getToken();
  const withAuth = options.withAuth ?? true;

  const headers: Record<string, string> = {
    ...(withAuth && token ? { Authorization: `Bearer ${token}` } : {}),
    Accept: "application/json",
    "Content-Type": "application/json",
  };

  let response: Response;

  try {
    response = await fetch(`${API_BASE_URL}${path}`, {
      method: options.method ?? "GET",
      headers,
      body: options.body ? JSON.stringify(options.body) : undefined,
    });
  } catch {
    throw new Error(
      "Network request failed: verifie que l'API est demarree et accessible sur le meme reseau."
    );
  }

  if (!response.ok) {
    let errorBody: ApiErrorBody | undefined;
    let message = `Erreur API (${response.status})`;

    try {
      errorBody = (await response.json()) as ApiErrorBody;
      message = errorBody.message ?? message;
    } catch {
      // Ignore JSON parsing error on non-JSON responses.
    }

    if (response.status === 401) {
      await clearToken();
    }

    throw new ApiError(message, response.status, errorBody?.errors);
  }

  if (response.status === 204) {
    return undefined as T;
  }

  return (await response.json()) as T;
}

type LoginResponse = {
  token: string;
  user: User;
};

export async function login(email: string, password: string): Promise<{ token: string; user: User }> {
  const data = await request<LoginResponse>("/auth/login", {
    method: "POST",
    body: { email, password },
    withAuth: false,
  });

  if (!data.token) {
    throw new Error("Token non retourne par l'API.");
  }

  // Sauvegarde le token et l'utilisateur dans AsyncStorage
  await setToken(data.token);
  await setUser(data.user as StoredUser);
  return { token: data.token, user: data.user };
}

export async function register(name: string, email: string, password: string): Promise<void> {
  await request("/auth/register", {
    method: "POST",
    body: { name, email, password, password_confirmation: password },
    withAuth: false,
  });
}

export async function me(): Promise<User> {
  return request<User>("/auth/me");
}

export async function resendVerificationEmail(): Promise<void> {
  const candidates = [
    "/email/verification-notification",
    "/email/resend",
    "/auth/email/resend",
  ];

  let lastError: unknown;

  for (const path of candidates) {
    try {
      await request(path, { method: "POST" });
      return;
    } catch (error) {
      lastError = error;
      if (error instanceof ApiError && error.status === 404) {
        continue;
      }
      throw error;
    }
  }

  if (lastError instanceof ApiError && lastError.status === 404) {
    throw new Error(
      "Aucune route de verification email trouvee (essayees: /email/verification-notification, /email/resend, /auth/email/resend)."
    );
  }

  throw new Error("Impossible d'envoyer l'email de verification.");
}

export async function logout(): Promise<void> {
  await request("/auth/logout", { method: "POST" });
}

export async function getCategories(): Promise<Category[]> {
  const data = await request<Category[] | { data?: Category[] }>("/categories", { withAuth: false });
  const list = Array.isArray(data) ? data : (data.data ?? []);
  return list.map(normalizeCategory);
}

export async function getUsers(): Promise<User[]> {
  const data = await request<User[] | { data?: User[] }>("/users");
  return Array.isArray(data) ? data : (data.data ?? []);
}

export async function updateUserRole(userId: number, role: RoleName): Promise<User> {
  const data = await request<{ message?: string; user?: User }>(`/users/${userId}/role`, {
    method: "PUT",
    body: { role },
  });

  if (!data.user) {
    throw new Error("Utilisateur non retourne par l'API.");
  }

  return data.user;
}

export async function createCategory(name_cat: string): Promise<Category> {
  const data = await request<Category>("/categories", { method: "POST", body: { name_cat } });
  return normalizeCategory(data);
}

export async function updateCategory(id: number, name_cat: string): Promise<Category> {
  const data = await request<Category>(`/categories/${id}`, { method: "PUT", body: { name_cat } });
  return normalizeCategory(data);
}

export async function deleteCategory(id: number): Promise<void> {
  await request(`/categories/${id}`, { method: "DELETE" });
}

export async function getResources(): Promise<ResourceItem[]> {
  const data = await request<ResourceItem[] | { data?: ResourceItem[] }>("/ressources", { withAuth: false });
  const list = Array.isArray(data) ? data : (data.data ?? []);
  return list.map(normalizeResource);
}

export async function getResourceById(id: number): Promise<ResourceItem> {
  const data = await request<ResourceItem>(`/ressources/${id}`, { withAuth: false });
  return normalizeResource(data);
}

export async function getResourceTypes(): Promise<ResourceType[]> {
  const data = await request<ResourceType[] | { data?: ResourceType[] }>("/types-ressources", { withAuth: false });
  const list = Array.isArray(data) ? data : (data.data ?? []);
  return list.map(normalizeResourceType);
}

export async function createResource(payload: ResourcePayload): Promise<ResourceItem> {
  const data = await request<ResourceItem>("/ressources", { method: "POST", body: payload });
  return normalizeResource(data);
}

export async function updateResource(id: number, payload: ResourcePayload): Promise<ResourceItem> {
  const data = await request<ResourceItem>(`/ressources/${id}`, { method: "PUT", body: payload });
  return normalizeResource(data);
}

export async function deleteResource(id: number): Promise<void> {
  await request(`/ressources/${id}`, { method: "DELETE" });
}

export async function moderateResource(id: number, action: "approve" | "reject"): Promise<ModerateResponse> {
  return request<ModerateResponse>(`/ressources/${id}/moderate`, {
    method: "POST",
    body: { action },
  });
}

export async function getResourceComments(resourceId: number): Promise<Comment[]> {
  const data = await request<Comment[]>(`/ressources/${resourceId}/comments`, { withAuth: false });
  return Array.isArray(data) ? data : [];
}

export async function postComment(resourceId: number, content: string): Promise<Comment> {
  return request<Comment>(`/ressources/${resourceId}/comments`, {
    method: "POST",
    body: { content },
  });
}
