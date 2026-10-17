<div class="backlink-workspace">
  <div class="backlink-intro"><span class="backlink-kicker">{{ __('BACKLINK WORKSPACE') }}</span><h2>{{ __('Understand your links. Choose your next move.') }}</h2><p>{{ __('Review domain-level link metrics, compare another website, and explore a sample of referring pages.') }}</p></div>
  <x-auth-validation-errors class="mb-4" :errors="$errors" />
  <form wire:submit.prevent="onBacklinkChecker" class="backlink-form">
    <div class="backlink-inputs"><div><label for="backlink-domain">{{ __('Your website') }}</label><input id="backlink-domain" type="text" wire:model.defer="link" placeholder="example.com" required maxlength="255" autocomplete="url"><small>{{ __('Enter a domain or URL. Reports cover the root domain.') }}</small></div><div><label for="backlink-compare">{{ __('Compare a website') }} <span>{{ __('Optional') }}</span></label><input id="backlink-compare" type="text" wire:model.defer="compare" placeholder="another-site.com" maxlength="255" autocomplete="off"><small>{{ __('See both websites side by side.') }}</small></div></div>
    @if ($generalSettings->captcha_status && ($generalSettings->captcha_for_registered || !auth()->check()))<x-public.recaptcha />@endif
    <div class="backlink-actions"><button type="submit" class="backlink-primary" wire:loading.attr="disabled"><span wire:loading.remove wire:target="onBacklinkChecker">{{ __('Analyze backlinks') }} <span aria-hidden="true">↗</span></span><span wire:loading wire:target="onBacklinkChecker">{{ __('Preparing your report…') }}</span></button><button type="button" class="backlink-secondary" wire:click="onSample" wire:loading.attr="disabled">{{ __('Use example') }}</button><button type="button" class="backlink-text-button" wire:click="onReset" wire:loading.attr="disabled">{{ __('Reset') }}</button></div>
  </form>

  @if (!empty($data))
    <section class="backlink-report" aria-labelledby="backlink-report-heading">
      <div class="backlink-section-heading"><div><span class="backlink-kicker">{{ __('DOMAIN OVERVIEW') }}</span><h2 id="backlink-report-heading">{{ $data['link'] }}</h2></div><button type="button" class="backlink-secondary" wire:click="exportCsv" wire:loading.attr="disabled">{{ __('Download CSV') }} <span aria-hidden="true">↓</span></button></div>
      <div class="backlink-stats">
        @foreach (['domain_authority' => __('Domain Authority'), 'linking_domains' => __('Referring domains'), 'total_links' => __('External linking pages'), 'nofollow_links' => __('Nofollow linking pages')] as $metric => $label)
          <div><span>{{ $label }}</span><strong>{{ isset($data[$metric]) ? number_format($data[$metric]) : '—' }}@if ($metric === 'domain_authority')<small>/100</small>@endif</strong></div>
        @endforeach
      </div>
      <p class="backlink-note">{{ __('Data from the Moz link index, retrieved') }} {{ \Illuminate\Support\Carbon::parse($data['checked_at'])->utc()->format('M j, Y H:i') }} UTC. {{ __('Reports may be cached for 10 minutes. Index data can differ from a live page and does not cover every link on the web. Domain Authority is a Moz metric, not a Google ranking score.') }}</p>
      @if (!empty($comparison))
        <div class="backlink-table-wrap"><table class="backlink-table"><caption>{{ __('Website comparison') }}</caption><thead><tr><th scope="col">{{ __('Metric') }}</th><th scope="col">{{ $data['link'] }}</th><th scope="col">{{ $comparison['link'] }}</th></tr></thead><tbody>@foreach (['domain_authority' => __('Domain Authority'), 'linking_domains' => __('Referring domains'), 'total_links' => __('External linking pages'), 'nofollow_links' => __('Nofollow linking pages')] as $metric => $label)<tr><th scope="row">{{ $label }}</th><td>{{ isset($data[$metric]) ? number_format($data[$metric]) : '—' }}</td><td>{{ isset($comparison[$metric]) ? number_format($comparison[$metric]) : '—' }}</td></tr>@endforeach</tbody></table></div>
      @endif
      <div class="backlink-detail-panel"><div><h3>{{ __('See where links come from') }}</h3><p>{{ __('Explore up to 25 indexed backlinks with anchor text, source authority, and last-seen dates. This is a sample, not a complete backlink export.') }}</p></div>@if (!$linksLoaded)<button type="button" class="backlink-primary" wire:click="loadBacklinks" wire:loading.attr="disabled"><span wire:loading.remove wire:target="loadBacklinks">{{ __('Explore backlinks') }} →</span><span wire:loading wire:target="loadBacklinks">{{ __('Loading backlinks…') }}</span></button>@endif</div>
      @if ($linksLoaded)
        <div class="backlink-filters"><label><span>{{ __('Search this sample') }}</span><input type="search" wire:model.debounce.250ms="linkSearch" placeholder="{{ __('Source, destination, or anchor text') }}"></label><label><span>{{ __('Link attribute') }}</span><select wire:model="linkType"><option value="all">{{ __('All links') }}</option><option value="follow">{{ __('Follow') }}</option><option value="nofollow">{{ __('Nofollow') }}</option></select></label><label><span>{{ __('Sort by') }}</span><select wire:model="linkSort"><option value="authority">{{ __('Source authority') }}</option><option value="recent">{{ __('Last seen') }}</option></select></label></div>
        <p class="backlink-note" role="status">{{ $filteredLinks->count() }} {{ __('shown from') }} {{ count($backlinks) }} {{ __('loaded backlinks.') }} @if ($hasMoreLinks){{ __('More links exist in the provider’s index.') }}@endif {{ __('CSV includes all loaded backlinks, regardless of filters. Follow means no nofollow flag was returned; it is not a guarantee of ranking value.') }}</p>
        <div class="backlink-table-wrap"><table class="backlink-table backlink-links-table"><thead><tr><th scope="col">{{ __('Source / destination') }}</th><th scope="col">{{ __('Anchor text') }}</th><th scope="col">{{ __('Source DA') }}</th><th scope="col">{{ __('Attribute') }}</th><th scope="col">{{ __('Last seen') }}</th></tr></thead><tbody>@forelse ($filteredLinks as $row)<tr><td>@php $sourceUrl = \App\Classes\BacklinkCheckerClass::safePageUrl($row['source']); @endphp @if ($sourceUrl)<a class="backlink-url" href="{{ $sourceUrl }}" target="_blank" rel="nofollow noopener noreferrer">{{ $row['source'] }} ↗</a>@else<span class="backlink-url">{{ $row['source'] ?: __('Not available') }}</span>@endif<small>{{ __('To:') }} {{ $row['target'] ?: '—' }}</small>@if ($row['redirect'])<small>{{ __('Redirect involved') }}</small>@endif</td><td>{{ $row['anchor'] !== '' ? $row['anchor'] : __('No text anchor') }}</td><td>{{ $row['domain_authority'] ?? '—' }}</td><td><span class="backlink-pill">{{ $row['nofollow'] ? __('Nofollow') : __('Follow') }}</span></td><td>{{ $row['last_seen'] ?: '—' }}</td></tr>@empty<tr><td colspan="5">{{ count($backlinks) ? __('No backlinks match these filters. Try a broader search.') : __('No backlinks were returned for this domain. This does not prove that the site has no links.') }}</td></tr>@endforelse</tbody></table></div>
      @endif
    </section>
  @endif

  <section class="backlink-services" aria-labelledby="backlink-services-heading"><span class="backlink-kicker">{{ __('MORE WAYS TO IMPROVE YOUR SITE') }}</span><h2 id="backlink-services-heading">{{ __('Turn your findings into action.') }}</h2><div class="backlink-service-grid">
    <a href="{{ url('/domain-authority-checker') }}"><span aria-hidden="true">↗</span><h3>{{ __('Check domain authority') }}</h3><p>{{ __('Look up Moz authority metrics for another website.') }}</p><strong>{{ __('Open tool') }} →</strong></a>
    <a href="{{ url('/redirect-checker') }}"><span aria-hidden="true">⇄</span><h3>{{ __('Trace a redirect') }}</h3><p>{{ __('See where a linked URL sends visitors and spot extra hops.') }}</p><strong>{{ __('Open tool') }} →</strong></a>
    <a href="{{ url('/http-status-code-checker') }}"><span aria-hidden="true">⌕</span><h3>{{ __('Check page availability') }}</h3><p>{{ __('Inspect a source or destination page’s HTTP response.') }}</p><strong>{{ __('Open tool') }} →</strong></a>
    <a href="{{ url('/backlink-monitoring-guide') }}"><span aria-hidden="true">≡</span><h3>{{ __('Plan your link monitoring') }}</h3><p>{{ __('Learn a repeatable workflow for reviewing new and lost links.') }}</p><strong>{{ __('Read guide') }} →</strong></a>
  </div></section>
  <style>
    .backlink-workspace{--bl-ink:#1b2134;--bl-muted:#666a79;--bl-line:#dee0e5;--bl-soft:#f2f3f6;--bl-card:#fff;--bl-accent:#112568;color:var(--bl-ink)}
    html.dark .backlink-workspace,body.theme-dark .backlink-workspace{--bl-ink:#f0f1f4;--bl-muted:#a5a9b8;--bl-line:#373a45;--bl-soft:#262934;--bl-card:#1c1e26;--bl-accent:#8698d4}
    .backlink-workspace .backlink-kicker{display:block;color:var(--bl-accent);font-size:10px;letter-spacing:.13em;font-weight:600;margin-bottom:10px}
    .backlink-workspace h2{font-size:clamp(1.35rem,2.4vw,1.9rem);line-height:1.2;color:var(--bl-ink)!important;margin:0 0 12px}
    .backlink-workspace h3{font-size:17px;color:var(--bl-ink)!important;margin:0 0 9px}
    .backlink-workspace p{font-size:14px;line-height:1.7;color:var(--bl-muted);margin:0}
    .backlink-workspace .backlink-intro{padding-bottom:24px}
    .backlink-workspace .backlink-form{padding:24px;border:1px solid var(--bl-line);background:var(--bl-soft);border-radius:12px}
    .backlink-workspace .backlink-inputs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}
    .backlink-workspace label{display:block;font-size:13px;font-weight:500;margin:0 0 9px;color:var(--bl-ink)}
    .backlink-workspace label span{color:var(--bl-muted);font-weight:400;font-size:11px;margin-left:6px}
    .backlink-workspace input,.backlink-workspace select{background:var(--bl-card);color:var(--bl-ink);border:1px solid var(--bl-line);border-radius:7px;padding:11px 13px;font-size:14px;width:100%;min-width:0}
    .backlink-workspace input:focus,.backlink-workspace select:focus{outline:2px solid var(--bl-accent);outline-offset:2px}
    .backlink-workspace small{display:block;font-size:11px;color:var(--bl-muted);margin-top:7px;line-height:1.6}
    .backlink-workspace .backlink-actions{display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-top:20px}
    .backlink-workspace button{font-size:13px;cursor:pointer;line-height:1.5}
    .backlink-workspace .backlink-primary{background:#112568;color:#fff;border:1px solid #112568;border-radius:7px;padding:11px 17px;white-space:nowrap}
    .backlink-workspace .backlink-secondary{background:var(--bl-card);color:var(--bl-ink);border:1px solid var(--bl-line);border-radius:7px;padding:11px 16px;white-space:nowrap}
    .backlink-workspace .backlink-text-button{background:transparent;color:var(--bl-muted);border:0;padding:10px}
    .backlink-workspace button:disabled{opacity:.6;cursor:wait}
    .backlink-workspace .backlink-report{padding-top:32px}
    .backlink-workspace .backlink-section-heading{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
    .backlink-workspace .backlink-section-heading h2{overflow-wrap:anywhere;margin:0}
    .backlink-workspace .backlink-stats{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-bottom:16px}
    .backlink-workspace .backlink-stats>div{padding:19px;border:1px solid var(--bl-line);background:var(--bl-card);border-radius:9px}
    .backlink-workspace .backlink-stats>div>span{font-size:12px;color:var(--bl-muted)}
    .backlink-workspace .backlink-stats strong{font-size:30px;display:block;line-height:1.4;overflow-wrap:anywhere;color:var(--bl-ink)}
    .backlink-workspace .backlink-stats strong small{display:inline;font-size:14px;margin-left:4px}
    .backlink-workspace .backlink-note{font-size:12px;margin:14px 0;color:var(--bl-muted);line-height:1.7}
    .backlink-workspace .backlink-table-wrap{max-width:100%;overflow-x:auto;border:1px solid var(--bl-line);border-radius:9px;margin:22px 0}
    .backlink-workspace .backlink-table{width:100%;border-collapse:collapse;font-size:12px;color:var(--bl-ink);text-align:left}
    .backlink-workspace .backlink-table caption{caption-side:top;padding:12px 15px;background:var(--bl-soft);color:var(--bl-ink);font-weight:500}
    .backlink-workspace .backlink-table th,.backlink-workspace .backlink-table td{padding:13px 15px;border-bottom:1px solid var(--bl-line);vertical-align:top}
    .backlink-workspace .backlink-table thead{background:var(--bl-soft)}
    .backlink-workspace .backlink-table tr:last-child td{border-bottom:0}
    .backlink-workspace .backlink-detail-panel{display:flex;align-items:center;gap:20px;padding:23px;background:var(--bl-soft);border:1px solid var(--bl-line);border-radius:10px;margin-top:25px}
    .backlink-workspace .backlink-detail-panel>div{flex:1}
    .backlink-workspace .backlink-filters{display:grid;grid-template-columns:2fr 1fr 1fr;gap:12px;margin-top:23px}
    .backlink-workspace .backlink-filters label>span{display:block;margin:0 0 7px}
    .backlink-workspace .backlink-filters input,.backlink-workspace .backlink-filters select{font-size:12px}
    .backlink-workspace .backlink-links-table{min-width:650px}
    .backlink-workspace .backlink-links-table td:first-child{min-width:230px;max-width:330px;overflow-wrap:anywhere}
    .backlink-workspace .backlink-url{font-weight:500}
    .backlink-workspace .backlink-pill{padding:4px 8px;background:var(--bl-soft);color:var(--bl-accent);border-radius:5px;white-space:nowrap;font-size:11px}
    .backlink-workspace .backlink-services{margin-top:36px;padding-top:28px;border-top:1px solid var(--bl-line)}
    .backlink-workspace .backlink-service-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px;margin-top:20px}
    .backlink-workspace .backlink-service-grid>a{display:flex;flex-direction:column;padding:22px;border:1px solid var(--bl-line);background:var(--bl-card);border-radius:10px;color:var(--bl-ink)!important;text-decoration:none;transition:border-color .2s}
    .backlink-workspace .backlink-service-grid>a:hover{border-color:var(--bl-accent)}
    .backlink-workspace .backlink-service-grid>a>span{font-size:25px;color:var(--bl-accent);margin-bottom:15px}
    .backlink-workspace .backlink-service-grid strong{display:block;color:var(--bl-accent);font-size:12px;font-weight:500;margin-top:auto;padding-top:17px}
    @media(max-width:640px){.backlink-workspace .backlink-inputs,.backlink-workspace .backlink-filters,.backlink-workspace .backlink-service-grid{grid-template-columns:minmax(0,1fr)}.backlink-workspace .backlink-form{padding:18px}.backlink-workspace .backlink-detail-panel{align-items:start;flex-direction:column;padding:18px}.backlink-workspace .backlink-section-heading{align-items:start;flex-direction:column}.backlink-workspace .backlink-stats>div{padding:13px}.backlink-workspace .backlink-stats strong{font-size:24px}}
  </style>
</div>
