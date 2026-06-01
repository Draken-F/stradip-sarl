
export function getApiUrl(path: string) {
  const baseUrl = import.meta.env.PUBLIC_API_URL || '';
  // Ensure path starts with / if baseUrl is present and doesn't end with /
  const normalizedPath = path.startsWith('/') ? path : `/${path}`;
  
  if (!baseUrl) return normalizedPath;
  
  // Remove trailing slash from baseUrl if it exists
  const cleanBaseUrl = baseUrl.endsWith('/') ? baseUrl.slice(0, -1) : baseUrl;
  return `${cleanBaseUrl}${normalizedPath}`;
}

export function getImageUrl(path: string) {
  if (!path) return '';
  if (path.startsWith('http')) return path;
  
  const baseUrl = import.meta.env.PUBLIC_API_URL || '';
  const normalizedPath = path.startsWith('/') ? path : `/${path}`;
  
  if (!baseUrl) return normalizedPath;
  
  const cleanBaseUrl = baseUrl.endsWith('/') ? baseUrl.slice(0, -1) : baseUrl;
  return `${cleanBaseUrl}${normalizedPath}`;
}
