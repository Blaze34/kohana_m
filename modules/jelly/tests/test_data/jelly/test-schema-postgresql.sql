DROP TABLE IF EXISTS test_authors;

CREATE TABLE test_authors (
  id serial,
  "name" varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  test_role_id bigint NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS test_roles;

CREATE TABLE test_roles (
  id serial,
  "name" varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS test_categories;

CREATE TABLE test_categories (
  id serial,
  "name" varchar(255) NOT NULL,
  parent_id bigint NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS test_posts;

CREATE TABLE test_posts (
  id serial,
  "name" varchar(255) NULL,
  slug varchar(255) NULL,
  status varchar(255) NULL,
  created bigint DEFAULT NULL,
  updated bigint DEFAULT NULL,
  published bigint DEFAULT NULL,
  test_author_id bigint DEFAULT NULL,
  approved_by bigint NULL,
  PRIMARY KEY (id),
  CHECK (status IN ('draft', 'review', 'published'))
);

DROP TABLE IF EXISTS test_categories_test_posts;

CREATE TABLE test_categories_test_posts (
  test_category_id bigint NOT NULL,
  test_post_id bigint NOT NULL
);