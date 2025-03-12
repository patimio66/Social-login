# Moduł Social Login do PrestaShop 8: Logowanie z Google i Facebookiem

**Social Login** to moduł dedykowany dla PrestaShop 8, który umożliwia Twoim klientom logowanie się na stronie sklepu za pomocą kont Google oraz Facebook. Dzięki temu rozwiązaniu proces logowania staje się szybszy i bardziej intuicyjny.

## Wymagania

- PrestaShop w wersji 8.x
- Certyfikat SSL
- Konto deweloperskie Google z utworzonymi odpowiednimi kluczami API oraz skonfigurowanym projektem
- Konto deweloperskie Facebook z utworzoną aplikacją i uzyskanym App ID oraz App Secret

## Konfiguracja

### Google

Aby moduł działał poprawnie, zarejestruj swój sklep w [Google Cloud Console](https://developers.google.com/identity/protocols/oauth2):

1. Na stronie konfiguracji modułu Social Login w PrestaShop znajdziesz link potrzebny do rejestracji w Google Cloud Console.
2. Po rejestracji otrzymasz **Google ID** oraz **Google Cloud Secret**. Wklej je w odpowiednie pola w panelu konfiguracji modułu w PrestaShop.

### Facebook

Aby włączyć logowanie za pomocą Facebooka, zarejestruj swoją aplikację (sklep PrestaShop) na [Facebook Developers](https://developers.facebook.com/apps/):

1. Podczas rejestracji wybierz **"Authenticate and request data from users with Facebook Login"** jako Use Case.
2. Po rejestracji przejdź do **Use Cases > Customize > Facebook Login > Settings**. W polu **Valid OAuth Redirect URIs** wklej link, który znajduje się na stronie konfiguracji modułu w PrestaShop.
3. Pod polem **Valid OAuth Redirect URIs**, w polu **Allowed Domains for the JavaScript SDK**, wklej adres swojej domeny, np. `https://example.xxx/`.
4. Włącz opcję **"Login with the JavaScript SDK"**.
5. **App ID** oraz **API version** znajdziesz w ustawieniach swojej aplikacji w Meta for Developers (**Settings > Basic** oraz **Settings > Advanced**). Skopiuj i wklej te dane w odpowiednie pola w konfiguracji modułu.

Po skonfigurowaniu i aktywacji modułu, przyciski logowania pojawią się na stronie logowania klientów w PrestaShop.

## Pobierz moduł

Pobierz moduł:  
[📦 Social Login (.zip)](https://github.com/Maniek247/oauthsignin/releases/download/Prestashop/oauthsignin.zip)

---

# Social Login Module for PrestaShop 8: Login with Google and Facebook

**Social Login** is a module dedicated to PrestaShop 8 that allows your customers to log in to your store using their Google or Facebook accounts. This solution makes the login process faster and more intuitive.

## Requirements

- PrestaShop version 8.x  
- SSL certificate  
- Google developer account with the required API keys and a properly configured project  
- Facebook developer account with a created app and obtained App ID and App Secret  

## Configuration

### Google

To ensure proper functionality, register your store in the [Google Cloud Console](https://developers.google.com/identity/protocols/oauth2):

1. On the Social Login module configuration page in PrestaShop, you will find the link required for registration in Google Cloud Console.
2. After registration, you will receive a **Google ID** and a **Google Cloud Secret**. Paste them into the configuration fields on the Social Login module page in your PrestaShop back office.

### Facebook

To enable Facebook login, register your application (your PrestaShop store) on [Facebook Developers](https://developers.facebook.com/apps/):

1. During registration, choose **"Authenticate and request data from users with Facebook Login"** as your Use Case.
2. Once registered, go to **Use Cases > Customize > Facebook Login > Settings**. In the **Valid OAuth Redirect URIs** field, paste the link that appears on the Social Login module configuration page in PrestaShop.
3. Under **Valid OAuth Redirect URIs**, in the **Allowed Domains for the JavaScript SDK** field, paste your domain address, e.g. `https://example.xxx/`.
4. Enable the **"Login with the JavaScript SDK"** option.
5. Your **App ID** and **API version** can be found in your app's settings in Meta for Developers (**Settings > Basic** and **Settings > Advanced**). Copy and paste them into the Social Login module configuration fields in PrestaShop.

After configuration and activation, the login buttons will appear on the PrestaShop customer login page.

## Download the Module

Download the module here:  
[📦 Social Login (.zip)](https://github.com/Maniek247/oauthsignin/releases/download/Prestashop/oauthsignin.zip)

---

© 2025 Adam Mańko