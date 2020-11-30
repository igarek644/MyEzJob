FROM webdevops/php-nginx:7.1

LABEL build_id="${BUILD_ID}" \
    version="${VERSION}" \
    description="MyEzJob Docker Image"

COPY . /app

WORKDIR /app