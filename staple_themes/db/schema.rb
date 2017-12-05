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

ActiveRecord::Schema.define(version: 20170930192037) do

  # These are extensions that must be enabled in order to support this database
  enable_extension "plpgsql"

  create_table "comments", id: :serial, force: :cascade do |t|
    t.text "body"
    t.integer "generation"
    t.string "submitted_by"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.string "commentable_type"
    t.integer "upvotes", default: 0, null: false
    t.integer "downvotes", default: 0, null: false
    t.integer "average_vote", default: 0, null: false
    t.boolean "edited", default: false, null: false
    t.integer "user_id"
    t.boolean "flagged", default: false, null: false
    t.boolean "deleted", default: false, null: false
    t.boolean "flag_checked", default: false, null: false
    t.string "deleted_body"
    t.string "deleted_submitted_by"
    t.string "deleted_user_id"
    t.boolean "hidden", default: false, null: false
    t.boolean "hide_proccessing", default: false, null: false
    t.jsonb "votes", default: {}, null: false
    t.integer "votes_count", default: 0, null: false
    t.text "marked", default: "", null: false
    t.text "stripped", default: "", null: false
    t.boolean "notified", default: false, null: false
    t.string "category"
    t.string "subcategory"
    t.string "url"
    t.string "post_type"
    t.string "post_id"
    t.integer "user_voted"
    t.string "title"
    t.boolean "admin", default: false, null: false
    t.boolean "seller", default: false, null: false
    t.boolean "submitter", default: false, null: false
    t.string "time_ago"
    t.boolean "styled", default: false, null: false
    t.boolean "archived", default: false, null: false
    t.integer "karma_update", default: 0, null: false
    t.boolean "voted", default: false, null: false
    t.boolean "removed", default: false, null: false
    t.boolean "locked", default: false, null: false
    t.boolean "stickied", default: false, null: false
    t.jsonb "votes_ip", default: {}, null: false
    t.boolean "checked", default: false, null: false
    t.boolean "reported", default: false, null: false
    t.text "report_users", default: [], null: false, array: true
    t.boolean "user_reported", default: false, null: false
    t.text "report_types", default: [], null: false, array: true
    t.integer "report_count", default: 0, null: false
    t.boolean "report_checked", default: false, null: false
    t.datetime "report_created"
    t.datetime "flag_created"
    t.jsonb "human_votes", default: {}, null: false
    t.integer "human_votes_count", default: 0, null: false
    t.integer "human_average_vote", default: 0, null: false
    t.integer "human_upvotes", default: 0, null: false
    t.integer "human_downvotes", default: 0, null: false
    t.string "uuid", default: "", null: false
    t.string "commentable_uuid", default: "", null: false
    t.string "parent_uuid", default: ""
    t.index ["commentable_type", "commentable_uuid"], name: "index_comments_on_commentable_type_and_commentable_uuid"
    t.index ["flag_checked"], name: "index_comments_on_flag_checked"
    t.index ["flagged"], name: "index_comments_on_flagged"
    t.index ["hidden"], name: "index_comments_on_hidden"
    t.index ["submitted_by"], name: "index_comments_on_submitted_by"
  end

  create_table "orders", id: :serial, force: :cascade do |t|
    t.integer "status", default: 1, null: false
    t.integer "type", default: 1, null: false
    t.integer "user_id"
    t.integer "theme_id"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
    t.decimal "total", precision: 8, scale: 2
    t.decimal "subtotal", precision: 8, scale: 2
    t.decimal "tax", precision: 8, scale: 2
    t.decimal "tax_rate", precision: 8, scale: 4, default: "0.0", null: false
    t.string "paid_with", default: ""
    t.string "stripe_payment_id", default: ""
    t.string "paypal_payment_id", default: ""
    t.index ["theme_id"], name: "index_orders_on_theme_id"
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

  create_table "themes", id: :serial, force: :cascade do |t|
    t.string "title", default: "", null: false
    t.string "category", default: "", null: false
    t.string "url", default: "", null: false
    t.integer "comment_count", default: 0, null: false
    t.boolean "hidden", default: false, null: false
    t.integer "user_rated"
    t.integer "average_rating", default: 100, null: false
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
    t.decimal "price", precision: 8, scale: 2
    t.decimal "sale_price", precision: 8, scale: 2
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
    t.index ["email"], name: "index_users_on_email", unique: true
    t.index ["reset_password_token"], name: "index_users_on_reset_password_token", unique: true
  end

  add_foreign_key "orders", "themes"
  add_foreign_key "orders", "users"
  add_foreign_key "themes", "users"
end
