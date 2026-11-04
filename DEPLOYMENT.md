# BengTix deployment (free demo)

This repository includes a Render Docker Blueprint for the Laravel app and expects
a PostgreSQL connection from Neon. Render's free web service has an ephemeral
filesystem and spins down when idle; Neon Free is the separate persistent database.
This setup is intended for a demo or small project, not production ticket sales.

## One-time setup

1. Create free accounts at [Neon](https://neon.tech/) and [Render](https://render.com/).
2. In Neon, create a PostgreSQL project and copy its pooled connection string.
   Keep the connection string private.
3. In Render, choose **New → Blueprint**, connect
   `kenzobakpo123-cell/ticketing-apps`, and deploy the `main` branch.
4. When Render asks for Blueprint variables, provide:
   - `DB_URL`: Neon PostgreSQL connection string, including `sslmode=require`.
   - `ADMIN_EMAIL`: email address for the initial administrator.
   - `ADMIN_PASSWORD`: a unique password of at least 12 characters. Do not reuse
     the local demo credentials.
5. After deployment, open the Render service's **Settings → Custom Domains** or
   its `onrender.com` URL. If the `bengtix.onrender.com` name is unavailable,
   use the generated URL and update `APP_URL` to match it.

The container applies database migrations at startup and creates the first admin
from the two private environment variables. It does not seed demo users or events
in production. It creates starter categories and a manual payment method; update
that method's payment instructions in the admin panel before accepting orders.

## Free-plan limitations

- The web service may take about a minute to wake after inactivity.
- Uploaded event images live on the web service's temporary filesystem and can
  disappear after a restart, sleep, or deploy. For ongoing use, connect durable
  object storage or use externally hosted image URLs.
- Neon Free scales its database to zero when idle; the first request after idle
  may be slower. Observe the current storage and compute quotas in its dashboard.
- Free tiers and provider terms can change. Back up important data and upgrade to
  paid, persistent hosting before relying on this for real ticket sales.
