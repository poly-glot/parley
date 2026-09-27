FROM europe-west2-docker.pkg.dev/firebase-cloud-491613/firebase-cloud/wp-base:7.1-r2

COPY wp-content /app/public/wp-content

RUN wp-build
