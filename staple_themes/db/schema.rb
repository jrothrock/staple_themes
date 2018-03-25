# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.rb definition is the authoritative source for your
# database schema. If you need to create the application database on another
# system, you should be using db:schema:load, not running all the migrations
# from scratch. The latter is a flawed and unsustainable approach (the more migrations
# you'll amass, the slower it'll run and the greater likelihood for issues).
#
# It's strongly recommended that you check this file into your version control system.

ActiveRecord::Schema.define(version: 20180326034040) do

  # These are extensions that must be enabled in order to support this database
  enable_extension "plpgsql"

  create_table "ckeditor_assets", force: :cascade do |t|
    t.string "data_file_name", null: false
    t.string "data_content_type"
    t.integer "data_file_size"
    t.string "type", limit: 30
    t.integer "width"
    t.integer "height"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.index ["type"], name: "index_ckeditor_assets_on_type"
  end

  create_table "comments", force: :cascade do |t|
    t.bigint "user_id"
    t.text "content"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.integer "rating", default: 0
    t.string "commentable_type"
    t.integer "commentable_id"
    t.index ["commentable_type", "commentable_id"], name: "index_comments_on_commentable_type_and_commentable_id"
    t.index ["user_id"], name: "index_comments_on_user_id"
  end

  create_table "discounts", force: :cascade do |t|
    t.string "name", default: "", null: false
    t.string "code", default: "", null: false
    t.decimal "amount", precision: 8, scale: 2
    t.boolean "expired", default: true, null: false
    t.integer "uses", default: 0, null: false
  end

  create_table "hostings", force: :cascade do |t|
    t.integer "user_id"
    t.integer "plan"
    t.string "website"
    t.integer "status"
    t.integer "payment_type"
    t.string "stripe_sub"
    t.string "uuid"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
  end

  create_table "orders", id: :serial, force: :cascade do |t|
    t.integer "status", default: 1, null: false
    t.integer "user_id"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.decimal "total", precision: 8, scale: 2
    t.decimal "subtotal", precision: 8, scale: 2
    t.decimal "tax", precision: 8, scale: 2
    t.decimal "tax_rate", precision: 8, scale: 4, default: "0.0", null: false
    t.string "paid_with", default: ""
    t.string "stripe_payment_id", default: ""
    t.string "paypal_payment_id", default: ""
    t.text "themes", default: [], null: false, array: true
    t.datetime "purchased_at"
    t.string "uuid", default: "", null: false
    t.text "licenses", default: [], null: false, array: true
    t.boolean "discounted", default: false, null: false
    t.decimal "discount", precision: 8, scale: 2
    t.decimal "discount_total", precision: 8, scale: 2
    t.decimal "discounted_total", precision: 8, scale: 2
    t.string "discount_code"
    t.text "plans", default: [], array: true
    t.text "photo_urls", default: [], array: true
    t.index ["user_id"], name: "index_orders_on_user_id"
  end

  create_table "photos", id: :serial, force: :cascade do |t|
    t.string "photo"
    t.string "photoable_type"
    t.string "user_uuid", default: "", null: false
    t.string "uuid"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.integer "photoable_id"
    t.index ["photoable_type", "photoable_id"], name: "index_photos_on_photoable_type_and_photoable_id"
  end

  create_table "posts", force: :cascade do |t|
    t.string "title"
    t.text "body"
    t.string "title_url"
    t.string "category"
    t.integer "comment_count", default: 0, null: false
    t.integer "likes_count", default: 0, null: false
    t.integer "user_id"
    t.text "likes", default: [], null: false, array: true
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.index ["user_id"], name: "index_posts_on_user_id"
  end

  create_table "themes", id: :serial, force: :cascade do |t|
    t.string "title", default: "", null: false
    t.string "category", default: "", null: false
    t.string "url", default: "", null: false
    t.integer "comment_count", default: 0, null: false
    t.boolean "hidden", default: false, null: false
    t.integer "user_rated"
    t.integer "ratings_count", default: 0, null: false
    t.jsonb "ratings", default: {}, null: false
    t.text "description"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.jsonb "properties", default: {}, null: false
    t.string "sub_category", default: "", null: false
    t.decimal "shipping", precision: 8, scale: 2
    t.string "shipping_type", default: "0", null: false
    t.decimal "tax", precision: 8, scale: 2
    t.tsvector "tsv_body"
    t.text "marked", default: "", null: false
    t.text "stripped", default: "", null: false
    t.integer "discount_percentage", default: 0, null: false
    t.integer "lock_version", default: 0, null: false
    t.jsonb "purchasers", default: {}, null: false
    t.boolean "updated", default: false, null: false
    t.boolean "archived", default: false, null: false
    t.boolean "locked", default: false, null: false
    t.jsonb "ratings_ip", default: {}, null: false
    t.jsonb "likes_ip", default: {}, null: false
    t.jsonb "extras"
    t.string "upload_url", default: "", null: false
    t.integer "total_views", default: 0, null: false
    t.jsonb "views", default: {}, null: false
    t.integer "user_views", default: 0, null: false
    t.integer "guest_views", default: 0, null: false
    t.jsonb "views_ip", default: {}, null: false
    t.jsonb "durations", default: {}, null: false
    t.jsonb "durations_ip", default: {}, null: false
    t.integer "average_duration", default: 0, null: false
    t.boolean "user_viewed", default: false, null: false
    t.integer "unique_views", default: 0, null: false
    t.boolean "removed"
    t.jsonb "old_properties", default: {}
    t.integer "human_ratings", default: 0, null: false
    t.integer "human_ratings_count", default: 0, null: false
    t.string "uuid", default: "", null: false
    t.integer "user_id"
    t.integer "purchase_type", default: 1
    t.string "purchase_url"
    t.decimal "average_rating", precision: 8, scale: 2, default: "0.0"
    t.string "excerpt"
    t.decimal "single_price", precision: 8, scale: 2
    t.decimal "single_sale_price", precision: 8, scale: 2
    t.decimal "multi_price", precision: 8, scale: 2
    t.decimal "multi_sale_price", precision: 8, scale: 2
    t.integer "purchases", default: 0, null: false
    t.string "download_url", default: "", null: false
    t.string "download_name", default: "", null: false
    t.string "title_url", default: "", null: false
    t.integer "downloads", default: 0, null: false
    t.text "photo_urls", default: [], array: true
    t.integer "upload_status", default: 0, null: false
    t.index "properties jsonb_path_ops", name: "products_properties_idx", using: :gin
    t.index ["created_at"], name: "index_product_on_created_at"
    t.index ["hidden"], name: "index_product_on_hidden"
    t.index ["sub_category"], name: "index_products_on_sub_category"
    t.index ["tsv_body"], name: "index_products_on_tsv_body", using: :gin
    t.index ["url"], name: "index_product_on_url"
    t.index ["user_id"], name: "index_themes_on_user_id"
  end

  create_table "users", id: :serial, force: :cascade do |t|
    t.string "firstname", default: "", null: false
    t.string "lastname", default: "", null: false
    t.string "email", default: "", null: false
    t.string "encrypted_password", default: "", null: false
    t.string "reset_password_token"
    t.datetime "reset_password_sent_at"
    t.datetime "remember_created_at"
    t.integer "sign_in_count", default: 0, null: false
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string "current_sign_in_ip"
    t.string "last_sign_in_ip"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.boolean "admin"
    t.string "username"
    t.string "uuid", default: "", null: false
    t.index ["email"], name: "index_users_on_email", unique: true
    t.index ["reset_password_token"], name: "index_users_on_reset_password_token", unique: true
  end

  add_foreign_key "comments", "users"
  add_foreign_key "orders", "users"
  add_foreign_key "themes", "users"
end
