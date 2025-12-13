CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "categories"(
  "id" integer primary key autoincrement not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "products"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "description" text,
  "price" numeric not null,
  "original_price" numeric,
  "tag" varchar,
  "image" varchar,
  "stock" integer not null default '0',
  "is_active" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  "jenis" varchar,
  "fungsi" varchar,
  "category" varchar,
  "slug" varchar
);
CREATE TABLE IF NOT EXISTS "cart_items"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "product_id" integer,
  "product_name" varchar not null,
  "tag" varchar,
  "image" varchar,
  "quantity" integer not null default '1',
  "price" integer not null,
  "original_price" integer,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE UNIQUE INDEX "cart_items_user_id_product_id_unique" on "cart_items"(
  "user_id",
  "product_id"
);
CREATE TABLE IF NOT EXISTS "order_items"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "product_id" integer,
  "product_name" varchar,
  "product_sku" varchar,
  "product_image" varchar,
  "quantity" integer not null default '1',
  "price" numeric not null default '0',
  "subtotal" numeric not null default '0',
  "total" numeric not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "wishlists"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "product_id" integer,
  "product_name" varchar not null,
  "product_image" varchar,
  "product_price" numeric not null,
  "product_original_price" numeric,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE UNIQUE INDEX "wishlists_user_id_product_name_unique" on "wishlists"(
  "user_id",
  "product_name"
);
CREATE TABLE IF NOT EXISTS "shops"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "nama_toko" varchar not null,
  "fokus_toko" varchar,
  "deskripsi_toko" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "phone" varchar,
  "is_seller" tinyint(1) not null default('0'),
  "address" text,
  "role" varchar not null default('buyer'),
  "google_id" varchar,
  "google_token" text,
  "google_refresh_token" text,
  "facebook_id" varchar,
  "facebook_token" text,
  "provider" varchar,
  "provider_id" varchar,
  "avatar" text,
  "verification_status" varchar,
  "ktp_number" varchar,
  "ktp_photo_path" varchar,
  "store_name" varchar,
  "store_address" text,
  "store_photo_path" varchar,
  "bank_name" varchar,
  "bank_account_number" varchar,
  "bank_account_name" varchar,
  "selfie_with_ktp_path" varchar,
  "verification_submitted_at" datetime,
  "verification_approved_at" datetime,
  "verification_rejected_at" datetime,
  "rejection_reason" text
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE UNIQUE INDEX "users_facebook_id_unique" on "users"("facebook_id");
CREATE UNIQUE INDEX "users_google_id_unique" on "users"("google_id");
CREATE INDEX "users_is_seller_index" on "users"("is_seller");
CREATE INDEX "users_role_index" on "users"("role");
CREATE UNIQUE INDEX "products_slug_unique" on "products"("slug");
CREATE TABLE IF NOT EXISTS "personal_access_tokens"(
  "id" integer primary key autoincrement not null,
  "tokenable_type" varchar not null,
  "tokenable_id" integer not null,
  "name" text not null,
  "token" varchar not null,
  "abilities" text,
  "last_used_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens"(
  "tokenable_type",
  "tokenable_id"
);
CREATE UNIQUE INDEX "personal_access_tokens_token_unique" on "personal_access_tokens"(
  "token"
);
CREATE INDEX "personal_access_tokens_expires_at_index" on "personal_access_tokens"(
  "expires_at"
);
CREATE TABLE IF NOT EXISTS "orders"(
  "id" integer primary key autoincrement not null,
  "order_code" varchar not null,
  "user_id" integer not null,
  "seller_id" integer,
  "total_price" numeric not null,
  "status" varchar not null default 'Menunggu',
  "shipping_address" text not null,
  "payment_method" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("seller_id") references "users"("id") on delete set null
);
CREATE UNIQUE INDEX "orders_order_code_unique" on "orders"("order_code");

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_11_13_140741_create_categories_table',1);
INSERT INTO migrations VALUES(5,'2025_11_13_140827_create_products_table',1);
INSERT INTO migrations VALUES(6,'2025_11_13_140900_create_cart_items_table',1);
INSERT INTO migrations VALUES(7,'2025_11_13_140909_create_order_items_table',1);
INSERT INTO migrations VALUES(8,'2025_11_17_120000_add_phone_is_seller_to_users_table',1);
INSERT INTO migrations VALUES(9,'2025_11_17_142118_create_wishlists_table',1);
INSERT INTO migrations VALUES(10,'2025_11_20_000000_add_address_to_users_table',1);
INSERT INTO migrations VALUES(11,'2025_11_20_120000_add_category_columns_to_products_table',1);
INSERT INTO migrations VALUES(12,'2025_11_20_141500_add_category_to_products_table',1);
INSERT INTO migrations VALUES(13,'2025_12_01_000001_add_role_phone_to_users_table',1);
INSERT INTO migrations VALUES(14,'2025_12_01_100838_create_shops_table',1);
INSERT INTO migrations VALUES(15,'2025_12_04_065300_add_social_login_fields_to_users_table',1);
INSERT INTO migrations VALUES(16,'2025_12_08_042121_add_seller_verification_fields_to_users_table',1);
INSERT INTO migrations VALUES(17,'2025_12_08_082003_fix_avatar_column_length_in_users_table',1);
INSERT INTO migrations VALUES(18,'2025_12_08_120000_add_slug_to_products_table',1);
INSERT INTO migrations VALUES(19,'2025_12_10_024331_create_personal_access_tokens_table',1);
INSERT INTO migrations VALUES(20,'2025_12_10_055413_create_orders_table',1);
