Broadway Sensitive Serializer Demo
====

![check dependencies](https://github.com/matiux/broadway-sensitive-serializer-demo/actions/workflows/check-dependencies.yml/badge.svg)
[![type coverage](https://shepherd.dev/github/matiux/broadway-sensitive-serializer-demo/coverage.svg)](https://shepherd.dev/github/matiux/broadway-sensitive-serializer-demo)
[![psalm level](https://shepherd.dev/github/matiux/broadway-sensitive-serializer-demo/level.svg)](https://shepherd.dev/github/matiux/broadway-sensitive-serializer-demo)
![security analysis status](https://github.com/matiux/broadway-sensitive-serializer-demo/actions/workflows/security-analysis.yml/badge.svg)
![coding standards status](https://github.com/matiux/broadway-sensitive-serializer-demo/actions/workflows/coding-standards.yml/badge.svg)
![PHP Version Support](https://img.shields.io/badge/php-%5E8.1-blue)

Symfony example of how to use the [matiux/broadway-sensitive-serializer](https://github.com/matiux/broadway-sensitive-serializer/wiki) library
in a CQRS + ES project made with [broadway/broadway](https://github.com/broadway/broadway) in order to make the system compliant with
the GDPR law.

You can switch between three branch:
* [whole_strategy](https://github.com/matiux/broadway-sensitive-serializer-demo/tree/whole_strategy)
* [partial_strategy](https://github.com/matiux/broadway-sensitive-serializer-demo/tree/partial_strategy)
* [custom_strategy](https://github.com/matiux/broadway-sensitive-serializer-demo/tree/custom_strategy)

### Setup for development

```shell
git clone https://github.com/matiux/broadway-sensitive-serializer-demo.git && cd sensitive-serializer-demo
cp docker/docker-compose.override.dist.yml docker/docker-compose.override.yml
rm -rf .git/hooks && ln -s ../scripts/git-hooks .git/hooks
./dc up -d
./dc project setup
```

This repository uses github actions to perform some checks. If you want to test the actions locally you can use [act](https://github.com/nektos/act).
For example if you want to check the action for static analysis
```
act -P ubuntu-latest=shivammathur/node:latest --job static-analysis
```

### Create User
```
./dc exec php bin/console sense:user:register <<name>> <<surname>> <<email>> | jq
```
### Add address to User
```
./dc exec php bin/console sense:user:add-address <<user-id>> <<address>>
```

### Show user list
```
./dc exec php bin/console sense:user:show-list | jq
```

### Forget user
```
./dc exec php bin/console sense:user:forget <<user-id>>
```

### Replay user events
```
./dc exec php bin/console sense:user:replay <<user-id>>
```

### Documentation

* [Demo wiki](https://github.com/matiux/broadway-sensitive-serializer-demo/wiki)
* [Library wiki](https://github.com/matiux/broadway-sensitive-serializer/wiki)
* [Bundle wiki](https://github.com/matiux/broadway-sensitive-serializer-bundle/blob/master/README.md)
* [DBAL AggregateKeys repository wiki](https://github.com/matiux/broadway-sensitive-serializer-dbal/blob/master/README.md)