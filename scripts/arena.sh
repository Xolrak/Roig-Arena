#!/bin/bash

cd ../roig-arena && ./vendor/bin/sail up -d

./vendor/bin/sail npm run dev

./vendor/bin/sail npm run build