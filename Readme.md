Broadway Sensitive Serializer Demo
====

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
```

### Documentation

* [Demo wiki](https://github.com/matiux/broadway-sensitive-serializer-demo/wiki)
* [Library wiki](https://github.com/matiux/broadway-sensitive-serializer/wiki)
* [Bundle wiki](https://github.com/matiux/broadway-sensitive-serializer-bundle/blob/master/README.md)
* [DBAL AggregateKeys repository wiki](https://github.com/matiux/broadway-sensitive-serializer-dbal/blob/master/README.md)