<?php

namespace Cards\Composer;

class Script {
  public static function install() {
    if (!is_dir('templates')) {
      mkdir('templates');
    }

    if (!is_dir('resources')) {
      mkdir('resources');
    }

    if (!is_dir('resources/cache')) {
      mkdir('resources/cache');
    }

    if (!is_dir('resources/twig')) {
      mkdir('resources/twig');
    }

    if (!is_dir('resources/session')) {
      mkdir('resources/session');
    }

    chmod('resources', 0775);
    chmod('resources/cache', 0775);
    chmod('resources/twig', 0775);
    chmod('templates', 0775);
  }
}
