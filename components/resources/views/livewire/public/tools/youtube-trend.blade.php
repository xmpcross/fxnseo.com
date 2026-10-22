<div>
    <form wire:submit.prevent="onYoutubeTrend">
        <div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
                                        
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>

        <!-- Quick Region Presets -->
        <div class="yt-region-shortcuts">
            <span class="yt-region-label"><i class="fas fa-bolt text-warning"></i> {{ __('Quick Markets:') }}</span>
            <button type="button" class="yt-region-pill @if(($country ?? 'US') == 'US') active @endif" wire:click="$set('country', 'US')">{{ __('🇺🇸 US') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'GB') active @endif" wire:click="$set('country', 'GB')">{{ __('🇬🇧 UK') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'CA') active @endif" wire:click="$set('country', 'CA')">{{ __('🇨🇦 Canada') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'AU') active @endif" wire:click="$set('country', 'AU')">{{ __('🇦🇺 Australia') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'DE') active @endif" wire:click="$set('country', 'DE')">{{ __('🇩🇪 Germany') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'IN') active @endif" wire:click="$set('country', 'IN')">{{ __('🇮🇳 India') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'JP') active @endif" wire:click="$set('country', 'JP')">{{ __('🇯🇵 Japan') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'BR') active @endif" wire:click="$set('country', 'BR')">{{ __('🇧🇷 Brazil') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'FR') active @endif" wire:click="$set('country', 'FR')">{{ __('🇫🇷 France') }}</button>
            <button type="button" class="yt-region-pill @if(($country ?? '') == 'MX') active @endif" wire:click="$set('country', 'MX')">{{ __('🇲🇽 Mexico') }}</button>
        </div>

        <!-- Form Inputs Grid -->
        <div class="yt-form-grid">
            <div class="yt-form-group">
                <label class="yt-field-label" for="yt-country-select">
                    <i class="fas fa-globe-americas"></i>
                    <span>{{ __('Target Country / Region') }}</span>
                </label>
                <select id="yt-country-select" class="yt-field-select" wire:model.defer="country" required>
                    <option value="US">{{ __('United States (US)') }}</option>
                    <option value="GB">{{ __('United Kingdom (GB)') }}</option>
                    <option value="CA">{{ __('Canada (CA)') }}</option>
                    <option value="AU">{{ __('Australia (AU)') }}</option>
                    <option value="IN">{{ __('India (IN)') }}</option>
                    <option value="DE">{{ __('Germany (DE)') }}</option>
                    <option value="FR">{{ __('France (FR)') }}</option>
                    <option value="JP">{{ __('Japan (JP)') }}</option>
                    <option value="BR">{{ __('Brazil (BR)') }}</option>
                    <option value="MX">{{ __('Mexico (MX)') }}</option>
                    <option disabled>──────────</option>
                    <option value="DZ">{{ __('Algeria') }}</option>
                    <option value="AR">{{ __('Argentina') }}</option>
                    <option value="AT">{{ __('Austria') }}</option>
                    <option value="AZ">{{ __('Azerbaijan') }}</option>
                    <option value="BH">{{ __('Bahrain') }}</option>
                    <option value="BD">{{ __('Bangladesh') }}</option>
                    <option value="BY">{{ __('Belarus') }}</option>
                    <option value="BE">{{ __('Belgium') }}</option>
                    <option value="BO">{{ __('Bolivia') }}</option>
                    <option value="BA">{{ __('Bosnia and Herzegovina') }}</option>
                    <option value="BG">{{ __('Bulgaria') }}</option>
                    <option value="CL">{{ __('Chile') }}</option>
                    <option value="CO">{{ __('Colombia') }}</option>
                    <option value="CR">{{ __('Costa Rica') }}</option>
                    <option value="HR">{{ __('Croatia') }}</option>
                    <option value="CY">{{ __('Cyprus') }}</option>
                    <option value="CZ">{{ __('Czechia') }}</option>
                    <option value="DK">{{ __('Denmark') }}</option>
                    <option value="DO">{{ __('Dominican Republic') }}</option>
                    <option value="EC">{{ __('Ecuador') }}</option>
                    <option value="EG">{{ __('Egypt') }}</option>
                    <option value="SV">{{ __('El Salvador') }}</option>
                    <option value="EE">{{ __('Estonia') }}</option>
                    <option value="FI">{{ __('Finland') }}</option>
                    <option value="GE">{{ __('Georgia') }}</option>
                    <option value="GH">{{ __('Ghana') }}</option>
                    <option value="GR">{{ __('Greece') }}</option>
                    <option value="GT">{{ __('Guatemala') }}</option>
                    <option value="HN">{{ __('Honduras') }}</option>
                    <option value="HU">{{ __('Hong Kong') }}</option>
                    <option value="IS">{{ __('Iceland') }}</option>
                    <option value="ID">{{ __('Indonesia') }}</option>
                    <option value="IQ">{{ __('Iraq') }}</option>
                    <option value="IE">{{ __('Ireland') }}</option>
                    <option value="IT">{{ __('Italy') }}</option>
                    <option value="JM">{{ __('Jamaica') }}</option>
                    <option value="JO">{{ __('Jordan') }}</option>
                    <option value="KZ">{{ __('Kazakhstan') }}</option>
                    <option value="KE">{{ __('Kenya') }}</option>
                    <option value="KW">{{ __('Kuwait') }}</option>
                    <option value="LV">{{ __('Latvia') }}</option>
                    <option value="LB">{{ __('Lebanon') }}</option>
                    <option value="LY">{{ __('Libya') }}</option>
                    <option value="LI">{{ __('Liechtenstein') }}</option>
                    <option value="LT">{{ __('Lithuania') }}</option>
                    <option value="LU">{{ __('Luxembourg') }}</option>
                    <option value="MY">{{ __('Malaysia') }}</option>
                    <option value="MT">{{ __('Malta') }}</option>
                    <option value="ME">{{ __('Montenegro') }}</option>
                    <option value="MA">{{ __('Morocco') }}</option>
                    <option value="NP">{{ __('Nepal') }}</option>
                    <option value="NL">{{ __('Netherlands') }}</option>
                    <option value="NZ">{{ __('New Zealand') }}</option>
                    <option value="NI">{{ __('Nicaragua') }}</option>
                    <option value="NG">{{ __('Nigeria') }}</option>
                    <option value="MK">{{ __('North Macedonia') }}</option>
                    <option value="NO">{{ __('Norway') }}</option>
                    <option value="OM">{{ __('Oman') }}</option>
                    <option value="PK">{{ __('Pakistan') }}</option>
                    <option value="PA">{{ __('Panama') }}</option>
                    <option value="PG">{{ __('Papua New Guinea') }}</option>
                    <option value="PY">{{ __('Paraguay') }}</option>
                    <option value="PE">{{ __('Peru') }}</option>
                    <option value="PH">{{ __('Philippines') }}</option>
                    <option value="PL">{{ __('Poland') }}</option>
                    <option value="PT">{{ __('Portugal') }}</option>
                    <option value="PR">{{ __('Puerto Rico') }}</option>
                    <option value="QA">{{ __('Qatar') }}</option>
                    <option value="RO">{{ __('Romania') }}</option>
                    <option value="RU">{{ __('Russia') }}</option>
                    <option value="SA">{{ __('Saudi Arabia') }}</option>
                    <option value="SN">{{ __('Senegal') }}</option>
                    <option value="RS">{{ __('Serbia') }}</option>
                    <option value="SG">{{ __('Singapore') }}</option>
                    <option value="SK">{{ __('Slovakia') }}</option>
                    <option value="SI">{{ __('Slovenia') }}</option>
                    <option value="ZA">{{ __('South Africa') }}</option>
                    <option value="KR">{{ __('South Korea') }}</option>
                    <option value="ES">{{ __('Spain') }}</option>
                    <option value="LK">{{ __('Sri Lanka') }}</option>
                    <option value="SE">{{ __('Sweden') }}</option>
                    <option value="CH">{{ __('Switzerland') }}</option>
                    <option value="TW">{{ __('Taiwan') }}</option>
                    <option value="TZ">{{ __('Tanzania') }}</option>
                    <option value="TH">{{ __('Thailand') }}</option>
                    <option value="TN">{{ __('Tunisia') }}</option>
                    <option value="TR">{{ __('Turkey') }}</option>
                    <option value="UG">{{ __('Uganda') }}</option>
                    <option value="UA">{{ __('Ukraine') }}</option>
                    <option value="AE">{{ __('United Arab Emirates') }}</option>
                    <option value="UY">{{ __('Uruguay') }}</option>
                    <option value="VE">{{ __('Venezuela') }}</option>
                    <option value="VN">{{ __('Vietnam') }}</option>
                    <option value="YE">{{ __('Yemen') }}</option>
                    <option value="ZW">{{ __('Zimbabwe') }}</option>
                </select>
            </div>

            <div class="yt-form-group">
                <label class="yt-field-label" for="yt-lang-select">
                    <i class="fas fa-language"></i>
                    <span>{{ __('Interface Language') }}</span>
                </label>
                <select id="yt-lang-select" class="yt-field-select" wire:model.defer="lang" required>
                    <option value="EN">{{ __('English (EN)') }}</option>
                    <option value="ES">{{ __('Spanish (ES)') }}</option>
                    <option value="FR">{{ __('French (FR)') }}</option>
                    <option value="DE">{{ __('German (DE)') }}</option>
                    <option value="HI">{{ __('Hindi (HI)') }}</option>
                    <option value="JA">{{ __('Japanese (JA)') }}</option>
                    <option value="PT">{{ __('Portuguese (PT)') }}</option>
                    <option value="ZH">{{ __('Chinese (Mandarin)') }}</option>
                    <option value="AR">{{ __('Arabic (AR)') }}</option>
                    <option disabled>──────────</option>
                    <option value="AF">{{ __('Afrikaans') }}</option>
                    <option value="SQ">{{ __('Albanian') }}</option>
                    <option value="HY">{{ __('Armenian') }}</option>
                    <option value="EU">{{ __('Basque') }}</option>
                    <option value="BN">{{ __('Bengali') }}</option>
                    <option value="BG">{{ __('Bulgarian') }}</option>
                    <option value="CA">{{ __('Catalan') }}</option>
                    <option value="KM">{{ __('Cambodian') }}</option>
                    <option value="HR">{{ __('Croatian') }}</option>
                    <option value="CS">{{ __('Czech') }}</option>
                    <option value="DA">{{ __('Danish') }}</option>
                    <option value="NL">{{ __('Dutch') }}</option>
                    <option value="ET">{{ __('Estonian') }}</option>
                    <option value="FJ">{{ __('Fiji') }}</option>
                    <option value="FI">{{ __('Finnish') }}</option>
                    <option value="KA">{{ __('Georgian') }}</option>
                    <option value="EL">{{ __('Greek') }}</option>
                    <option value="GU">{{ __('Gujarati') }}</option>
                    <option value="HE">{{ __('Hebrew') }}</option>
                    <option value="HU">{{ __('Hungarian') }}</option>
                    <option value="IS">{{ __('Icelandic') }}</option>
                    <option value="ID">{{ __('Indonesian') }}</option>
                    <option value="GA">{{ __('Irish') }}</option>
                    <option value="IT">{{ __('Italian') }}</option>
                    <option value="JW">{{ __('Javanese') }}</option>
                    <option value="KO">{{ __('Korean') }}</option>
                    <option value="LA">{{ __('Latin') }}</option>
                    <option value="LV">{{ __('Latvian') }}</option>
                    <option value="LT">{{ __('Lithuanian') }}</option>
                    <option value="MK">{{ __('Macedonian') }}</option>
                    <option value="MS">{{ __('Malay') }}</option>
                    <option value="ML">{{ __('Malayalam') }}</option>
                    <option value="MT">{{ __('Maltese') }}</option>
                    <option value="MI">{{ __('Maori') }}</option>
                    <option value="MR">{{ __('Marathi') }}</option>
                    <option value="MN">{{ __('Mongolian') }}</option>
                    <option value="NE">{{ __('Nepali') }}</option>
                    <option value="NO">{{ __('Norwegian') }}</option>
                    <option value="FA">{{ __('Persian') }}</option>
                    <option value="PL">{{ __('Polish') }}</option>
                    <option value="PA">{{ __('Punjabi') }}</option>
                    <option value="QU">{{ __('Quechua') }}</option>
                    <option value="RO">{{ __('Romanian') }}</option>
                    <option value="RU">{{ __('Russian') }}</option>
                    <option value="SM">{{ __('Samoan') }}</option>
                    <option value="SR">{{ __('Serbian') }}</option>
                    <option value="SK">{{ __('Slovak') }}</option>
                    <option value="SL">{{ __('Slovenian') }}</option>
                    <option value="SW">{{ __('Swahili') }}</option>
                    <option value="SV">{{ __('Swedish') }}</option>
                    <option value="TA">{{ __('Tamil') }}</option>
                    <option value="TT">{{ __('Tatar') }}</option>
                    <option value="TE">{{ __('Telugu') }}</option>
                    <option value="TH">{{ __('Thai') }}</option>
                    <option value="BO">{{ __('Tibetan') }}</option>
                    <option value="TO">{{ __('Tonga') }}</option>
                    <option value="TR">{{ __('Turkish') }}</option>
                    <option value="UK">{{ __('Ukrainian') }}</option>
                    <option value="UR">{{ __('Urdu') }}</option>
                    <option value="UZ">{{ __('Uzbek') }}</option>
                    <option value="VI">{{ __('Vietnamese') }}</option>
                    <option value="CY">{{ __('Welsh') }}</option>
                    <option value="XH">{{ __('Xhosa') }}</option>
                </select>
            </div>

            <div class="yt-form-group">
                <label class="yt-field-label" for="yt-result-count">
                    <i class="fas fa-list-ol"></i>
                    <span>{{ __('Result Limit') }}</span>
                </label>
                <select id="yt-result-count" class="yt-field-select" wire:model.defer="result" required>
                    <option value="5">{{ __('Top 5 Trending Videos (Fast)') }}</option>
                    <option value="10" selected>{{ __('Top 10 Trending Videos (Recommended)') }}</option>
                    <option value="25">{{ __('Top 25 Trending Videos (Detailed)') }}</option>
                    <option value="50">{{ __('Top 50 Trending Videos (Comprehensive)') }}</option>
                </select>
            </div>
        </div>

        @if ($generalSettings->captcha_status && ($generalSettings->captcha_for_registered || !auth()->check()))
            <div class="d-flex justify-content-center mb-3">
                <x-public.recaptcha />
            </div>
        @endif

        <div class="yt-submit-wrapper">
            <button type="submit" class="yt-submit-btn" wire:loading.attr="disabled">
                <div wire:loading.inline wire:target="onYoutubeTrend" style="display: none;">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                </div>
                <span wire:loading.remove wire:target="onYoutubeTrend"><i class="fas fa-bolt me-1"></i> {{ __('Fetch Trending Videos') }}</span>
                <span wire:loading wire:target="onYoutubeTrend">{{ __('Retrieving Real-Time Trends...') }}</span>
            </button>
        </div>
    </form>

    <!-- Results Display -->
    @if ( !empty($data) )
        <div class="yt-results-shell" id="trend-results-container">
            <div class="yt-results-header">
                <div class="yt-results-count">
                    <span class="fire-icon">🔥</span>
                    <span>{{ __('Showing') }} <strong class="text-success">{{ count($data) }}</strong> {{ __('Trending Videos in') }} <strong>{{ $country }}</strong></span>
                </div>
                <div class="yt-results-actions">
                    <input type="text" id="yt-live-filter" class="yt-filter-input" placeholder="{{ __('Filter title or tags...') }}" onkeyup="ytFilterResults(this.value)">
                    <button type="button" class="yt-copy-all-btn" onclick="ytCopyAllExtractedTags()">
                        <i class="fas fa-copy"></i>
                        <span>{{ __('Copy All Extracted Tags') }}</span>
                    </button>
                </div>
            </div>

            <!-- Video Cards Grid -->
            <div class="yt-video-grid" id="yt-video-grid">
                @php
                    $allCombinedTags = [];
                @endphp

                @foreach ($data as $key => $value)
                    @php
                        $tagsList = !empty($value['tags'][0]) ? $value['tags'][0] : [];
                        foreach($tagsList as $t) {
                            if(!in_array($t, $allCombinedTags)) { $allCombinedTags[] = $t; }
                        }
                        $rankClass = ($loop->iteration === 1) ? 'rank-1' : (($loop->iteration === 2) ? 'rank-2' : (($loop->iteration === 3) ? 'rank-3' : 'rank-other'));
                        $rankLabel = ($loop->iteration === 1) ? '🥇 #1 TRENDING' : (($loop->iteration === 2) ? '🥈 #2 TRENDING' : (($loop->iteration === 3) ? '🥉 #3 TRENDING' : '#'.$loop->iteration));
                        $formattedViews = !empty($value['viewCount']) ? number_format($value['viewCount']) . ' views' : null;
                        $channel = !empty($value['channelTitle']) ? $value['channelTitle'] : 'YouTube Creator';
                    @endphp

                    <div class="yt-video-card" data-video-item data-search="{{ strtolower($value['title'] . ' ' . $channel . ' ' . implode(' ', $tagsList)) }}">
                        <!-- Thumbnail Wrapper -->
                        <div class="yt-card-thumb-wrap">
                            <span class="yt-rank-badge {{ $rankClass }}">{{ $rankLabel }}</span>
                            <img src="{{ $value['thumbnail'] }}" alt="{{ $value['title'] }}" loading="lazy">
                            @if ($formattedViews)
                                <span class="yt-views-badge"><i class="far fa-eye"></i> {{ $formattedViews }}</span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="yt-card-body">
                            <div class="yt-card-channel">
                                <i class="fab fa-youtube"></i>
                                <span>{{ $channel }}</span>
                            </div>

                            <a href="{{ $value['link'] }}" target="_blank" rel="noopener noreferrer" class="yt-card-title" title="{{ $value['title'] }}">
                                {{ $value['title'] }}
                            </a>

                            <div class="yt-card-meta">
                                @if (!empty($value['publishedAt']))
                                    <span><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($value['publishedAt'])->diffForHumans() }}</span>
                                    <span>•</span>
                                @endif
                                <span><i class="fas fa-tag"></i> {{ count($tagsList) }} {{ __('tags') }}</span>
                            </div>

                            <!-- Tags Cloud -->
                            <div class="yt-card-tags-section">
                                <div class="yt-tags-header">
                                    <span class="yt-tags-label"><i class="fas fa-tags text-emerald-600"></i> {{ __('Tags:') }}</span>
                                    @if(count($tagsList) > 0)
                                        <button type="button" class="yt-copy-tags-link" onclick="ytCopyText('{{ addslashes(implode(', ', $tagsList)) }}', this)">
                                            {{ __('Copy Video Tags') }}
                                        </button>
                                    @endif
                                </div>

                                <div class="yt-tags-cloud">
                                    @if (!empty($tagsList))
                                        @foreach ($tagsList as $element)
                                            <span class="yt-tag-chip" onclick="ytCopyTag('{{ addslashes($element) }}', this)" title="{{ __('Click to copy this tag') }}">
                                                #{{ $element }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">{{ __('No public tags set by creator') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Action Buttons -->
                            <div class="yt-card-actions">
                                <a href="{{ $value['link'] }}" target="_blank" rel="noopener noreferrer" class="yt-watch-btn">
                                    <i class="fab fa-youtube"></i>
                                    <span>{{ __('Watch on YouTube') }}</span>
                                    <i class="fas fa-external-link-alt ms-1" style="font-size: 0.72rem;"></i>
                                </a>
                                <button type="button" class="yt-copy-url-btn" onclick="ytCopyText('{{ $value['link'] }}', this)" title="{{ __('Copy video URL') }}">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Hidden container for batch tag copying -->
            <div id="yt-all-tags-stash" style="display:none;">{{ implode(', ', $allCombinedTags) }}</div>
        </div>
    @else
        <!-- Initial Guidance State Before Query -->
        <div class="yt-empty-intro">
            <div class="yt-empty-icon">
                <i class="fab fa-youtube"></i>
            </div>
            <h3 class="yt-empty-title">{{ __('Ready to Uncover Viral YouTube Content?') }}</h3>
            <p class="yt-empty-desc">{{ __('Select your target country and language above, then click Fetch Trending Videos to inspect live YouTube ranking signals, view velocity, and audience search tags.') }}</p>

            <div class="yt-feature-row">
                <div class="yt-feature-card">
                    <h4><i class="fas fa-chart-line"></i> {{ __('Spot Rising Trends Early') }}</h4>
                    <p>{{ __('Monitor videos surging in viewership right now so you can create timely response content before competition peaks.') }}</p>
                </div>
                <div class="yt-feature-card">
                    <h4><i class="fas fa-tags"></i> {{ __('Reverse-Engineer Top Tags') }}</h4>
                    <p>{{ __('Extract the exact keyword metadata used by high-ranking videos to increase your chances in suggested recommendations.') }}</p>
                </div>
                <div class="yt-feature-card">
                    <h4><i class="fas fa-globe"></i> {{ __('Compare 80+ Markets') }}</h4>
                    <p>{{ __('Identify cultural and regional interest variations across North America, Europe, Asia, Latin America, and beyond.') }}</p>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    // Live filter search for video cards
    function ytFilterResults(query) {
        query = (query || '').toLowerCase().trim();
        const cards = document.querySelectorAll('#yt-video-grid [data-video-item]');
        cards.forEach(card => {
            const haystack = card.getAttribute('data-search') || '';
            if (!query || haystack.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Copy single tag with toast
    function ytCopyTag(text, element) {
        if (!navigator.clipboard) return;
        navigator.clipboard.writeText(text).then(() => {
            const originalText = element.textContent;
            element.textContent = '✓ Copied!';
            element.style.background = '#6c86f5';
            element.style.color = '#ffffff';
            element.style.borderColor = '#6c86f5';
            setTimeout(() => {
                element.textContent = originalText;
                element.style.background = '';
                element.style.color = '';
                element.style.borderColor = '';
            }, 1200);
            ytShowToast('Copied tag: #' + text);
        });
    }

    // Generic copy with button feedback
    function ytCopyText(text, btn) {
        if (!navigator.clipboard) return;
        navigator.clipboard.writeText(text).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> ' + (btn.classList.contains('yt-copy-tags-link') ? 'Copied!' : '');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
            }, 1500);
            ytShowToast('Copied to clipboard!');
        });
    }

    // Copy all extracted tags combined
    function ytCopyAllExtractedTags() {
        const stash = document.getElementById('yt-all-tags-stash');
        if (!stash || !stash.textContent.trim()) {
            ytShowToast('No tags found to copy.');
            return;
        }
        navigator.clipboard.writeText(stash.textContent.trim()).then(() => {
            ytShowToast('✓ All extracted tags copied to clipboard!');
        });
    }

    // Toast notification
    function ytShowToast(message) {
        const existing = document.querySelector('.yt-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'yt-toast';
        toast.innerHTML = '<i class="fas fa-check-circle text-emerald-400"></i> ' + message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2200);
    }
</script>