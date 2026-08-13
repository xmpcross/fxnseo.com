<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>fxnSEO — Homepage redesign preview</title>
  <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.'.localization()->getCurrentLocaleDirection().'.min.css') }}">
  <style>
    :root{--ink:#12211b;--muted:#607069;--green:#147a55;--green2:#20a36f;--mint:#e8f7f0;--line:#dce7e1;--paper:#f7faf8;--amber:#f4b84a}*{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--paper);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}a{color:inherit}.wrap{width:min(1180px,calc(100% - 40px));margin:auto}.nav{height:76px;display:flex;align-items:center;gap:32px}.logo img{width:174px;height:auto;display:block}.navlinks{display:flex;gap:27px;margin-left:auto;font-size:14px;font-weight:650}.navlinks a{text-decoration:none;color:#405149}.navlinks a:hover{color:var(--green)}.nav-actions{display:flex;gap:9px}.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:10px;padding:12px 17px;text-decoration:none;font-size:14px;font-weight:750;border:1px solid var(--line);background:white}.btn.primary{background:var(--green);border-color:var(--green);color:white;box-shadow:0 8px 22px #147a5524}.hero{position:relative;overflow:hidden;padding:78px 0 86px;background:radial-gradient(circle at 82% 20%,#bfead6 0,transparent 31%),linear-gradient(145deg,#f8fcfa 15%,#e7f7ef 100%);border-block:1px solid var(--line)}.hero:after{content:"";position:absolute;width:430px;height:430px;right:-150px;bottom:-280px;border:70px solid #fff9;border-radius:50%}.hero-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:70px;align-items:center;position:relative;z-index:1}.eyebrow{display:inline-flex;gap:8px;align-items:center;color:var(--green);font-size:12px;font-weight:800;letter-spacing:.1em;text-transform:uppercase}.eyebrow:before{content:"";width:26px;height:2px;background:var(--green)}h1{font-family:Georgia,"Times New Roman",serif;font-size:clamp(45px,6vw,72px);line-height:1.02;letter-spacing:-.045em;margin:20px 0 22px;max-width:780px}h1 span{color:var(--green)}.hero p{font-size:18px;line-height:1.7;color:var(--muted);max-width:660px}.search{margin-top:32px;background:white;border:1px solid #cfe0d7;border-radius:14px;padding:7px;display:flex;box-shadow:0 16px 45px #173c2d14;max-width:670px}.search input{flex:1;border:0;outline:0;padding:0 15px;font-size:15px;min-width:0}.search button{border:0;border-radius:9px;background:var(--green);color:white;padding:14px 19px;font-weight:750;cursor:pointer}.proof{display:flex;gap:26px;margin-top:25px;color:#52635b;font-size:13px}.proof span:before{content:"✓";color:var(--green);font-weight:900;margin-right:7px}.hero-panel{background:#173e31;color:white;border-radius:24px;padding:27px;box-shadow:0 30px 70px #153d2f26;transform:rotate(1.2deg)}.panel-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}.panel-head strong{font-family:Georgia,serif;font-size:20px}.live{font-size:11px;background:#ffffff17;padding:7px 10px;border-radius:20px}.score{display:grid;grid-template-columns:repeat(3,1fr);gap:9px}.score div{background:#ffffff0c;border:1px solid #ffffff16;border-radius:13px;padding:16px 12px}.score b{font:700 26px Georgia,serif;display:block}.score small{color:#bcd1c8}.activity{margin-top:16px;background:white;color:var(--ink);border-radius:15px;padding:17px}.activity-row{display:grid;grid-template-columns:36px 1fr auto;gap:11px;align-items:center;padding:10px 0;border-bottom:1px solid #edf1ef}.activity-row:last-child{border:0}.ico{width:36px;height:36px;display:grid;place-items:center;background:var(--mint);color:var(--green);border-radius:9px;font-weight:900}.activity-row strong{display:block;font-size:13px}.activity-row small{color:#819088}.tag{font-size:10px;font-weight:800;color:var(--green);background:var(--mint);padding:5px 7px;border-radius:5px}.section{padding:80px 0}.section.white{background:white;border-block:1px solid var(--line)}.section-head{display:flex;align-items:end;justify-content:space-between;gap:30px;margin-bottom:30px}.section h2{font:650 clamp(32px,4vw,46px)/1.08 Georgia,serif;letter-spacing:-.025em;margin:10px 0}.section-head p{color:var(--muted);line-height:1.7;max-width:550px}.tool-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}.tool{background:white;border:1px solid var(--line);border-radius:16px;padding:22px;text-decoration:none;transition:.2s;display:grid;grid-template-columns:46px 1fr auto;gap:14px;align-items:center}.tool:hover{transform:translateY(-3px);border-color:#9bcab5;box-shadow:0 13px 28px #173c2d0d}.tool .ico{width:46px;height:46px;font-size:18px}.tool strong{display:block;margin-bottom:5px}.tool small{color:var(--muted);line-height:1.5}.arrow{color:var(--green);font-size:20px}.workflow{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.workflow article{padding:29px;border-radius:18px;background:#f7faf8;border:1px solid var(--line)}.num{font:700 13px Georgia,serif;color:var(--green);letter-spacing:.1em}.workflow h3{font:650 22px Georgia,serif;margin:16px 0 10px}.workflow p{color:var(--muted);line-height:1.65;margin:0}.resource-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:17px}.resource{background:white;border:1px solid var(--line);border-radius:17px;padding:24px;text-decoration:none;min-height:205px;display:flex;flex-direction:column}.resource .label{font-size:11px;font-weight:850;color:var(--green);text-transform:uppercase;letter-spacing:.09em}.resource h3{font:650 22px/1.25 Georgia,serif;margin:16px 0 11px}.resource p{font-size:14px;color:var(--muted);line-height:1.6}.resource b{margin-top:auto;color:var(--green);font-size:13px}.cta{padding:30px 0 80px}.cta-box{background:linear-gradient(135deg,#123d2e,#176746);color:white;padding:48px;border-radius:24px;display:flex;align-items:center;justify-content:space-between;gap:30px;box-shadow:0 24px 65px #153d2f25}.cta h2{font:650 36px Georgia,serif;margin:0 0 10px}.cta p{color:#c7ded4;margin:0}.cta .btn{border-color:white}.footer{border-top:1px solid var(--line);padding:32px 0 45px;color:var(--muted);font-size:13px}.footer .wrap{display:flex;justify-content:space-between;gap:20px}.preview-note{position:fixed;z-index:20;right:18px;bottom:18px;background:#16251f;color:white;padding:10px 14px;border-radius:9px;font-size:11px;box-shadow:0 8px 30px #0002}.preview-note b{color:#83dbb4}@media(max-width:900px){.navlinks{display:none}.hero-grid{grid-template-columns:1fr}.hero-panel{display:none}.tool-grid,.workflow,.resource-grid{grid-template-columns:1fr 1fr}.section-head,.cta-box{align-items:flex-start;flex-direction:column}}@media(max-width:620px){.wrap{width:min(100% - 26px,1180px)}.nav{height:66px}.logo img{width:145px}.nav-actions .btn:first-child{display:none}.hero{padding:58px 0}.proof{flex-direction:column;gap:8px}.search{display:block}.search input{width:100%;height:48px}.search button{width:100%}.tool-grid,.workflow,.resource-grid{grid-template-columns:1fr}.section{padding:60px 0}.cta-box{padding:31px}.footer .wrap{flex-direction:column}}
  </style>
  <link rel="stylesheet" href="{{ asset('assets/css/shared-public-components.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/shared-public-components.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/recap-color-scheme.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/recap-color-scheme.css') ?: '1' }}">
</head>
<body>
  <header class="wrap nav">
    <a class="logo" href="{{ route('homepage.preview') }}"><img src="{{ asset('assets/img/logo-light.svg') }}" alt="fxnSEO"></a>
    <nav class="navlinks"><a href="{{ route('home') }}#tools-box">All tools</a><a href="#workflows">How it works</a><a href="{{ route('public.resources') }}">Resources</a><a href="{{ url('/blog') }}">Blog</a></nav>
    <div class="nav-actions"><a class="btn" href="{{ url('/login') }}">Log in</a><a class="btn primary" href="#tools">Explore tools</a></div>
  </header>

  <main>
    <section class="hero">
      <div class="wrap hero-grid">
        <div>
          <span class="eyebrow">SEO clarity without the clutter</span>
          <h1>Make every search decision <span>count.</span></h1>
          <p>Fast, focused SEO tools for checking authority, fixing technical issues, understanding links, and creating pages that deserve to rank.</p>
          <form class="search" onsubmit="return findTool(event)"><input id="tool-search" aria-label="Find an SEO tool" placeholder="What do you want to check? e.g. backlinks, metadata, redirects"><button>Find a tool →</button></form>
          <div class="proof"><span>Free essential tools</span><span>No complex setup</span><span>Actionable results</span></div>
        </div>
        <aside class="hero-panel">
          <div class="panel-head"><strong>Your free SEO toolbox</strong><span class="live">No installation</span></div>
          <div class="score"><div><b>60+</b><small>Web tools</small></div><div><b>1</b><small>URL to start</small></div><div><b>0</b><small>Software installs</small></div></div>
          <div class="activity"><a class="activity-row" href="{{ url('/domain-authority-checker') }}" style="text-decoration:none"><span class="ico">DA</span><div><strong>Domain Authority Checker</strong><small>Estimate a domain's authority</small></div><span class="tag">Open →</span></a><a class="activity-row" href="{{ url('/meta-tags-analyzer') }}" style="text-decoration:none"><span class="ico">T</span><div><strong>Meta Tags Analyzer</strong><small>Inspect titles, descriptions and tags</small></div><span class="tag">Open →</span></a><a class="activity-row" href="{{ url('/redirect-checker') }}" style="text-decoration:none"><span class="ico">⌁</span><div><strong>Redirect Checker</strong><small>Trace redirects and status codes</small></div><span class="tag">Open →</span></a></div>
        </aside>
      </div>
    </section>

    <section class="section" id="tools"><div class="wrap">
      <div class="section-head"><div><span class="eyebrow">Start with the essentials</span><h2>Popular SEO tools</h2></div><div><p>Purpose-built checks available directly on fxnseo.com, giving you a useful answer without complicated software.</p><a class="btn" href="{{ route('home') }}#tools-box">Browse every tool →</a></div></div>
      <div class="tool-grid" id="tool-grid">
        @foreach ([
          ['backlink-checker','↗','Backlink Checker','See the links pointing to a domain.'],
          ['domain-authority-checker','DA','Domain Authority Checker','Estimate the strength of any domain.'],
          ['meta-tags-analyzer','T','Meta Tags Analyzer','Review titles, descriptions and social tags.'],
          ['redirect-checker','⌁','Redirect Checker','Trace status codes and redirect chains.'],
          ['keyword-density-checker','K','Keyword Density Checker','Spot repetition and content imbalance.'],
          ['robots-txt-generator','R','Robots.txt Generator','Create crawler instructions with confidence.'],
          ['page-size-checker','▣','Page Size Checker','Find oversized pages and heavy assets.'],
          ['google-index-checker','G','Google Index Checker','Check whether pages appear in the index.'],
          ['open-graph-generator','◎','Open Graph Generator','Create richer social sharing previews.']
        ] as [$slug,$icon,$title,$desc])
          <a class="tool" data-title="{{ strtolower($title.' '.$desc) }}" href="{{ url('/'.$slug) }}"><span class="ico">{{ $icon }}</span><span><strong>{{ $title }}</strong><small>{{ $desc }}</small></span><span class="arrow">→</span></a>
        @endforeach
      </div>
    </div></section>

    <section class="section white" id="workflows"><div class="wrap">
      <div class="section-head"><div><span class="eyebrow">A simpler workflow</span><h2>From question to useful result</h2></div><p>Use an individual fxnseo.com tool whenever you need a focused website, domain, content, or technical check.</p></div>
      <div class="workflow"><article><span class="num">01 / CHOOSE</span><h3>Pick the right web tool</h3><p>Search the toolbox for the exact check, generator, or converter you need.</p></article><article><span class="num">02 / ENTER</span><h3>Provide the required input</h3><p>Paste a URL, domain, text, or other details requested by the selected tool.</p></article><article><span class="num">03 / USE</span><h3>Review your result</h3><p>Read, copy, or download the result produced by that tool and continue your work.</p></article></div>
    </div></section>

    <section class="section"><div class="wrap">
      <div class="section-head"><div><span class="eyebrow">Learn the why</span><h2>Fresh SEO resources</h2></div><a class="btn" href="{{ route('public.resources') }}">View all resources →</a></div>
      <div class="resource-grid">
        @forelse ($resources as $post)
          <a class="resource" href="{{ route('public.resource', $post['slug']) }}"><span class="label">Guide</span><h3>{{ $post['title'] }}</h3><p>{{ \Illuminate\Support\Str::limit($post['excerpt'] ?? '', 145) }}</p><b>Read resource →</b></a>
        @empty
          <a class="resource" href="{{ route('public.resources') }}"><span class="label">Resources</span><h3>Practical SEO guidance</h3><p>Explore useful guides for improving visibility and protecting organic performance.</p><b>Browse resources →</b></a>
        @endforelse
      </div>
    </div></section>

    <section class="cta"><div class="wrap"><div class="cta-box"><div><h2>Know what to improve next.</h2><p>Choose a focused tool and turn SEO uncertainty into a concrete action.</p></div><a class="btn" href="#tools">Explore free SEO tools →</a></div></div></section>
  </main>
  <x-public.footer :footer="$footer" :general="$general" :socials="$socials" />
  <div class="preview-note"><b>Preview</b> · Current homepage is unchanged</div>
  <script>function findTool(e){e.preventDefault();const q=document.getElementById('tool-search').value.trim().toLowerCase();const cards=[...document.querySelectorAll('.tool')];let first=null;cards.forEach(c=>{const match=!q||c.dataset.title.includes(q);c.style.display=match?'grid':'none';if(match&&!first)first=c});document.getElementById('tools').scrollIntoView({behavior:'smooth'});if(first){first.style.boxShadow='0 0 0 3px #20a36f55';setTimeout(()=>first.style.boxShadow='',1800)}return false}</script>
</body>
</html>
