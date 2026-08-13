<aside class="cookie-consent" id="cookieConsent" role="dialog" aria-modal="false" aria-labelledby="cookieConsentTitle" aria-describedby="cookieConsentText">
  <div class="cookie-consent-icon" aria-hidden="true"><i class="fas fa-cookie-bite"></i></div>
  <div class="cookie-consent-copy">
    <h2 id="cookieConsentTitle">{{ __('Your privacy, your choice') }}</h2>
    <p id="cookieConsentText">{{ __('We use necessary cookies to keep fxnSEO working. With your permission, optional cookies may help us understand usage and improve the site.') }} <a href="{{ url('/cookie-information') }}">{{ __('Cookie Info') }}</a></p>
  </div>
  <div class="cookie-consent-actions">
    <button class="cookie-consent-secondary" id="rejectCookies" type="button">{{ __('Necessary only') }}</button>
    <button class="cookie-consent-primary" id="acceptCookies" type="button">{{ __('Accept all') }}</button>
  </div>
</aside>

<script>
  (function () {
    const banner = document.getElementById('cookieConsent');
    if (!banner) return;
    function saveChoice(choice) {
      fetch('{{ url('/cookies') }}/' + choice, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      })
        .then(function () { banner.remove(); document.dispatchEvent(new CustomEvent('fxnseo:cookie-consent', { detail: choice })); })
        .catch(function () { banner.remove(); });
    }
    document.getElementById('acceptCookies')?.addEventListener('click', function () { saveChoice('accept'); });
    document.getElementById('rejectCookies')?.addEventListener('click', function () { saveChoice('reject'); });
  })();
</script>
