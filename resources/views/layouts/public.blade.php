<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ElectricalFollowFlow — AI Lead Follow-Up Autopilot for Electrical Contractors')</title>
    <meta name="description" content="@yield('meta_description', 'Consent-aware AI follow-ups, escalations, service requests, technicians, and job tickets for electrical contractors.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,600;0,9..40,700;1,9..40,400&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0f1720;
            --muted: #5b6675;
            --line: #d7dde6;
            --paper: #f4f7fb;
            --card: #ffffff;
            --amber: #e6a100;
            --amber-deep: #b87a00;
            --volt: #1f8a5b;
            --navy: #16324f;
            --glow: rgba(230, 161, 0, 0.18);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "DM Sans", system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1200px 500px at 10% -10%, var(--glow), transparent 60%),
                linear-gradient(180deg, #eef3f8 0%, var(--paper) 40%, #e9eef5 100%);
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin: 0 auto; }
        header {
            position: sticky; top: 0; z-index: 20;
            backdrop-filter: blur(10px);
            background: rgba(244, 247, 251, 0.86);
            border-bottom: 1px solid rgba(215, 221, 230, 0.8);
        }
        .nav { display: flex; align-items: center; justify-content: space-between; padding: 0.9rem 0; gap: 1rem; }
        .brand { font-family: "Space Grotesk", sans-serif; font-weight: 700; font-size: 1.15rem; letter-spacing: -0.02em; }
        .brand span { color: var(--amber-deep); }
        .nav-links { display: flex; flex-wrap: wrap; gap: 0.9rem; align-items: center; font-size: 0.95rem; color: var(--muted); }
        .nav-links a:hover { color: var(--ink); }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 999px; padding: 0.7rem 1.15rem; font-weight: 600;
            border: 1px solid transparent; transition: 0.18s ease;
        }
        .btn-primary { background: var(--navy); color: #fff; }
        .btn-primary:hover { background: #0f2439; }
        .btn-secondary { background: #fff; border-color: var(--line); color: var(--ink); }
        .btn-secondary:hover { border-color: var(--amber); }
        .hero {
            padding: 4.5rem 0 3rem;
            display: grid; gap: 1.5rem;
            animation: rise 0.7s ease both;
        }
        .eyebrow {
            display: inline-block; color: var(--amber-deep); font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase; font-size: 0.78rem;
        }
        h1, h2, h3 { font-family: "Space Grotesk", sans-serif; letter-spacing: -0.03em; margin: 0; }
        h1 { font-size: clamp(2.2rem, 5vw, 3.6rem); line-height: 1.05; max-width: 16ch; }
        h2 { font-size: clamp(1.6rem, 3vw, 2.2rem); }
        .lede { color: var(--muted); font-size: 1.1rem; max-width: 58ch; line-height: 1.6; }
        .cta-row { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 0.5rem; }
        .panel {
            background: linear-gradient(145deg, #12263d, #1a3a5c 55%, #245074);
            color: #eef5ff; border-radius: 1.4rem; padding: 1.5rem;
            box-shadow: 0 20px 50px rgba(22, 50, 79, 0.25);
            animation: floatIn 0.9s ease both;
        }
        .panel h3 { margin-bottom: 0.75rem; }
        .panel ul { margin: 0; padding-left: 1.1rem; line-height: 1.7; color: #d7e6f7; }
        .section { padding: 2.5rem 0; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .card {
            background: var(--card); border: 1px solid var(--line); border-radius: 1rem;
            padding: 1.15rem 1.2rem; transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(15, 23, 32, 0.08); }
        .card h3 { font-size: 1.05rem; margin-bottom: 0.4rem; }
        .card p { margin: 0; color: var(--muted); line-height: 1.55; font-size: 0.96rem; }
        .pill {
            display: inline-block; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.55rem;
            border-radius: 999px; margin-bottom: 0.55rem;
        }
        .on { background: #dff5ea; color: var(--volt); }
        .off { background: #eeeef2; color: #6b7280; }
        .steps { display: grid; gap: 0.9rem; }
        .step {
            display: grid; grid-template-columns: auto 1fr; gap: 0.9rem; align-items: start;
            background: #fff; border: 1px solid var(--line); border-radius: 1rem; padding: 1rem 1.1rem;
        }
        .num {
            width: 2rem; height: 2rem; border-radius: 999px; display: grid; place-items: center;
            background: var(--amber); color: #1a1300; font-weight: 700;
        }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 1rem; overflow: hidden; border: 1px solid var(--line); }
        th, td { text-align: left; padding: 0.85rem 1rem; border-bottom: 1px solid var(--line); font-size: 0.95rem; }
        th { background: #f8fafc; }
        footer { padding: 2.5rem 0 3rem; color: var(--muted); border-top: 1px solid var(--line); margin-top: 2rem; }
        @keyframes rise { from { opacity: 0; transform: translateY(14px);} to { opacity: 1; transform: none; } }
        @keyframes floatIn { from { opacity: 0; transform: translateY(18px) scale(0.98);} to { opacity: 1; transform: none; } }
        @media (min-width: 900px) {
            .hero { grid-template-columns: 1.2fr 0.8fr; align-items: center; }
        }
    </style>
</head>
<body>
<header>
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">Electrical<span>FollowFlow</span></a>
        <nav class="nav-links">
            <a href="{{ route('features') }}">Features</a>
            <a href="{{ route('workflow') }}">Workflow</a>
            <a href="{{ route('pricing') }}">Pricing</a>
            <a href="{{ route('demo') }}">Demo Users</a>
            <a class="btn btn-primary" href="/admin">Admin Login</a>
        </nav>
    </div>
</header>
<main>
    @yield('content')
</main>
<footer>
    <div class="wrap">
        <strong>ElectricalFollowFlow</strong> — AI Lead Follow-Up Autopilot for Electrical Contractors.<br>
        Built with Laravel + Filament · Modular SaaS · Consent-aware messaging
    </div>
</footer>
</body>
</html>
