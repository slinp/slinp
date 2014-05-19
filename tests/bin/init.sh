#!/bin/bash

DIR_NAME=`dirname $0`

# composer install --dev
php $DIR_NAME"/console" doctrine:phpcr:init:dbal --drop
php $DIR_NAME"/console" doctrine:phpcr:repository:init

