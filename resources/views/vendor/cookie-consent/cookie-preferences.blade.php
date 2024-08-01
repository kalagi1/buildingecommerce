<!-- Modal -->
<div class="modal fade" id="cookiePreferencesModal" tabindex="-1" aria-labelledby="cookiePreferencesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cookiePreferencesModalLabel">Çerez Tercihlerinizi Yönet</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="cookiePreferencesForm" action="{{ route('cookie-preferences.update') }}" method="POST">
            @csrf
            <!-- Çerez tercihlerini yönetmek için gerekli form elemanlarını buraya ekleyin -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="cookie_analytics" id="cookieAnalytics" {{ old('cookie_analytics', true) ? 'checked' : '' }}>
              <label class="form-check-label" for="cookieAnalytics">
                Analitik Çerezler
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="cookie_marketing" id="cookieMarketing" {{ old('cookie_marketing', true) ? 'checked' : '' }}>
              <label class="form-check-label" for="cookieMarketing">
                Pazarlama Çerezleri
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="cookie_functional" id="cookieFunctional" {{ old('cookie_functional', true) ? 'checked' : '' }}>
              <label class="form-check-label" for="cookieFunctional">
                Fonksiyonel Çerezler
              </label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
          <button type="submit" form="cookiePreferencesForm" class="btn btn-primary">Tercihleri Kaydet</button>
        </div>
      </div>
    </div>
  </div>
  