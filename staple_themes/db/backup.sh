ls -t /home/deploy/staple_themes/db/backups/*.sql | sed -e '1,13d' | xargs -d '\n' rm
echo Done at `date +\%Y-\%m-\%d_\%T`
pg_dump staple_themes_production --username=staple --password=staple > /home/deploy/staple_themes/db/backups/`date +\%Y-\%m-\%d_\%T`.sql
