<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumni Network API</title>
    <meta name="description" content="Alumni Network: a team-built Laravel API for alumni, students and universities. Try it live with demo accounts.">
    <style>
        :root { --bg: #fafafa; --surface: #fff; --border: #e4e4e7; --text: #52525b; --text-h: #09090b; --accent: #4f46e5; --accent-bg: rgba(79, 70, 229, .08); }
        @media (prefers-color-scheme: dark) {
            :root { --bg: #0b0d12; --surface: #12151c; --border: #232733; --text: #a1a1aa; --text-h: #f4f4f5; --accent: #818cf8; --accent-bg: rgba(129, 140, 248, .1); }
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: var(--text); font: 16px/1.6 system-ui, 'Segoe UI', Roboto, sans-serif; }
        .wrap { max-width: 880px; margin: 0 auto; padding: 48px 16px 64px; }
        h1 { color: var(--text-h); font-size: 40px; margin: 0; letter-spacing: -.02em; }
        h2 { color: var(--text-h); font-size: 20px; margin: 40px 0 12px; }
        .tag { display: inline-block; margin-bottom: 10px; padding: 2px 10px; border: 1px solid var(--border); border-radius: 999px; font-size: 13px; }
        .lead { font-size: 18px; margin: 8px 0 24px; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .btn { display: inline-block; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; border: 1px solid var(--border); color: var(--text-h); background: var(--surface); }
        .btn.primary { background: var(--accent); border-color: var(--accent); color: #fff; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 4px 16px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { text-align: left; padding: 10px 4px; border-bottom: 1px solid var(--border); vertical-align: top; }
        tr:last-child td { border-bottom: 0; }
        th { color: var(--text-h); font-size: 14px; }
        code { font-family: ui-monospace, Consolas, monospace; font-size: 14px; background: var(--accent-bg); color: var(--text-h); padding: 2px 6px; border-radius: 4px; overflow-wrap: anywhere; }
        a { color: var(--accent); }
        ol, ul { padding-left: 20px; margin: 0; }
        li { margin: 6px 0; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; }
        .grid .card { padding: 14px 16px; }
        .grid b { color: var(--text-h); display: block; margin-bottom: 4px; }
        .note { font-size: 14px; margin-top: 12px; }
        footer { margin-top: 48px; font-size: 14px; }
        @media (max-width: 560px) { h1 { font-size: 32px; } .hide-sm { display: none; } }
    </style>
</head>
<body>
<main class="wrap">
    <span class="tag">Team project</span>
    <h1>Alumni Network API</h1>
    <p class="lead">A Laravel API that connects university alumni, students and university admins: profiles, connections, posts, jobs, mentorship, events and notifications.</p>
    <div class="actions">
        <a class="btn primary" href="{{ url('/docs/api') }}">Try the API in your browser →</a>
        <a class="btn" href="https://github.com/khederAlkhateeb/Alumni-Network">Team repository</a>
        <a class="btn" href="https://github.com/hasan123dayoub-del/Alumni-Network">This fork</a>
    </div>

    <h2>Try the events flow</h2>
    <div class="card" style="padding: 14px 16px">
        <ol>
            <li>Open the <a href="{{ url('/docs/api') }}">interactive docs</a> and send <code>POST /api/v1/auth/login</code> (pre-filled with the student account), then copy <code>data.token</code>.</li>
            <li>Paste it as the <b>Bearer token</b> and call <code>GET /api/v1/universities/1/events</code> to see Northbridge University's events.</li>
            <li>Register with <code>POST /api/v1/universities/1/events/{event}/register</code>.</li>
            <li>Log in as the university admin to list registrations and record attendance for <b>Northbridge Hackathon Week</b>, which is running now.</li>
            <li>Back as the student: <code>GET /api/v1/notifications</code> and <code>POST /api/v1/notifications/read-all</code>.</li>
        </ol>
    </div>

    <h2>Demo accounts</h2>
    <div class="card">
        <table>
            <tr><th>Role</th><th>Email</th><th>Password</th></tr>
            <tr><td>Student</td><td><code>student@alumni.demo</code></td><td><code>password</code></td></tr>
            <tr><td>Alumni</td><td><code>alumni@alumni.demo</code></td><td><code>password</code></td></tr>
            <tr><td>University admin</td><td><code>uniadmin@alumni.demo</code></td><td><code>password</code></td></tr>
            <tr><td>Super admin</td><td><code>admin@alumni.demo</code></td><td><code>password</code></td></tr>
        </table>
    </div>

    <h2>Public endpoint (no token needed)</h2>
    <div class="card">
        <table>
            <tr><td><a href="{{ url('/api/v1/universities') }}"><code>GET /api/v1/universities</code></a></td><td>Universities on the platform</td></tr>
        </table>
    </div>

    <h2>Hasan Dayoub's part of this team project</h2>
    <div class="grid">
        <div class="card"><b>Events</b>University events: CRUD, registration with a capacity check under a row lock, attendance, and scheduled reminders.</div>
        <div class="card"><b>Notifications</b>Endpoints to list notifications and mark one or all as read, plus queued jobs and real-time Pusher delivery.</div>
        <div class="card"><b>Password management</b>Forgot and reset password by email, and change password for signed-in users.</div>
        <div class="card"><b>Tests</b>Pest feature tests for the events, notifications and password features.</div>
    </div>

    <p class="note">Free hosting: the server sleeps when idle, so the first request can take up to a minute. The demo database is reset on every restart, and real-time Pusher delivery and emails are turned off in this demo.</p>

    <footer>Deployed by <a href="https://hasan123dayoub-del.github.io/portfolio/">Hasan Dayoub</a>. The rest of the API was built by the team.</footer>
</main>
</body>
</html>
