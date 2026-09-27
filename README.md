# WordPress client template

Client site scaffold for the agency WordPress platform. WordPress core, wp-config,
mu-plugins (yacf, GCS uploads) and the APCu object cache live in the `wp-base` image;
this repo owns only what is unique to the client.

## What you own

| Path | Purpose |
| --- | --- |
| `wp-content/themes/` | The client theme |
| `wp-content/plugins/` | Client plugins (rarely needed) |
| `wp-content/yacf/` | Content model: post types, taxonomies, fields, options pages (YAML) |
| `wp-content/seed/` | Optional `seed.php` (idempotent content seed, run via `wp eval-file`) plus its images |
| `wp-content/config.php` | Optional per-site wp-config additions, loaded if present |
| `Dockerfile` | Three lines; bump the `wp-base` tag to take platform updates |

## Local development

Open in the devcontainer. It builds the image, starts MariaDB, installs WordPress
(admin / password), builds the yacf model and runs the seed if present.
Site: http://localhost:8080

The devcontainer mounts your `wp-content` dirs into the running image and enables
OPcache timestamp validation, so edits apply on refresh.

## Onboarding checklist (new client)

1. Create the repo from this template.
2. firebase-cloud: `cp terraform/apps/_wordpress-template.tf.example terraform/apps/<app>.tf`,
   set app_name/github_repo/database_name, add the catalog entry in `apps/mysql-catalog.tf`
   and the four outputs in `apps/outputs.tf`, then `terraform apply`.
3. personal-cloud: `gh workflow run terraform-mysql-apps.yaml --repo poly-glot/personal-cloud --ref main`
   to provision the database and secret versions.
4. `gh secret set WIF_PROVIDER -R poly-glot/<app> --body "$(terraform output -raw <app>_wif_provider)"`
   and the same for `GCP_SA_EMAIL` from `<app>_gcp_sa_email`.
5. Push to main — the deploy workflow builds and deploys Cloud Run service `<repo-name>`.
6. First install: run the seed from a devcontainer pointed at the production DB, or a
   one-off Cloud Run job (`php wp-content/seed/seed.php` bootstraps wp-load).

## Production

Pushes to `main` deploy to Cloud Run (service name = repo name) in
`firebase-cloud-491613` / `europe-west2`. Media uploads go to the app's GCS bucket
via the runtime service account. wp-cron runs from Cloud Scheduler; file mods are
disabled on Cloud Run.
