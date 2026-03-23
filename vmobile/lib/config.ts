import Constants from "expo-constants";

type ExpoExtra = {
	apiBaseUrl?: string;
};

type ExpoConfigWithExtra = {
	hostUri?: string;
	extra?: ExpoExtra;
} | null;

const expoConfig = Constants.expoConfig as ExpoConfigWithExtra;

function normalizeUrl(url: string): string {
	return url.replace(/\/$/, "");
}

function getApiFromExpoHost(): string | null {
	const hostUri = expoConfig?.hostUri;
	if (!hostUri) {
		return null;
	}

	const host = hostUri.split(":")[0]?.trim();
	if (!host) {
		return null;
	}

	return `http://${host}:8000/api`;
}

const configuredApiBaseUrl = expoConfig?.extra?.apiBaseUrl?.trim();

export const API_BASE_URL = normalizeUrl(
	configuredApiBaseUrl ||
		getApiFromExpoHost() ||
		"http://192.168.1.144:8000/api"
);
