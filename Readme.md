Broadway Sensitive Serializer Demo
====

```shell
php bin/console sense:user:register <<name>> <<surname>> <<email>>
php bin/console sense:user:add-address <<user-id>> <<address>>
```

## WIP command
```shell
php bin/console debug:container broadway_sensitive_serializer --show-arguments
php bin/console debug:container --parameter=matiux.broadway.sensitive_serializer.strategy
```