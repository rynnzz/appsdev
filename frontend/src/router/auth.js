const tokenKey = "authToken";
let authToken = sessionStorage.getItem(tokenKey);

export function checkIfUserIsAuthenticated() {
  return authToken !== null && authToken !== undefined;
}

export function simulateLogin() {
  authToken = generateAuthToken();
  sessionStorage.setItem(tokenKey, authToken);
}

export function simulateLogout() {
  authToken = null;
  sessionStorage.removeItem(tokenKey);
  sessionStorage.removeItem('userFirstName')
  sessionStorage.removeItem('userData')
  sessionStorage.removeItem('userType')
}

function generateAuthToken() {
  return Math.random().toString(36).substring(2) + Date.now().toString(36);
}
