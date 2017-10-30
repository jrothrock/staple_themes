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

  create_table "orders", force: :cascade do |t|
    t.integer  "status",                                    default: 1,     null: false
    t.integer  "type",                                      default: 1,     null: false
    t.integer  "user_id"
    t.integer  "theme_id"
    t.datetime "created_at",                                                null: false
    t.datetime "updated_at",                                                null: false
    t.decimal  "total",             precision: 8, scale: 2
    t.decimal  "subtotal",          precision: 8, scale: 2
    t.decimal  "tax",               precision: 8, scale: 2
    t.decimal  "tax_rate",          precision: 8, scale: 4, default: "0.0", null: false
    t.string   "paid_with",                                 default: ""
    t.string   "stripe_payment_id",                         default: ""
    t.string   "paypal_payment_id",                         default: ""
    t.index ["theme_id"], name: "index_orders_on_theme_id", using: :btree
    t.index ["user_id"], name: "index_orders_on_user_id", using: :btree
  end

  create_table "photos", force: :cascade do |t|
    t.string   "photo"
    t.string   "photoable_type"
    t.string   "user_uuid",      default: "", null: false
    t.string   "uuid"
    t.datetime "created_at",                  null: false
    t.datetime "updated_at",                  null: false
    t.integer  "photoable_id"
    t.index ["photoable_type", "photoable_id"], name: "index_photos_on_photoable_type_and_photoable_id", using: :btree
  end

  create_table "themes", force: :cascade do |t|
    t.string   "title",                                       default: "",    null: false
    t.string   "category",                                    default: "",    null: false
    t.string   "url",                                         default: "",    null: false
    t.integer  "comment_count",                               default: 0,     null: false
    t.boolean  "hidden",                                      default: false, null: false
    t.integer  "user_rated"
    t.integer  "average_rating",                              default: 100,   null: false
    t.integer  "ratings_count",                               default: 0,     null: false
    t.jsonb    "ratings",                                     default: {},    null: false
    t.text     "description"
    t.datetime "created_at",                                                  null: false
    t.datetime "updated_at",                                                  null: false
    t.jsonb    "properties",                                  default: {},    null: false
    t.string   "sub_category",                                default: "",    null: false
    t.decimal  "shipping",            precision: 8, scale: 2
    t.string   "shipping_type",                               default: "0",   null: false
    t.decimal  "tax",                 precision: 8, scale: 2
    t.tsvector "tsv_body"
    t.text     "marked",                                      default: "",    null: false
    t.text     "stripped",                                    default: "",    null: false
    t.integer  "discount_percentage",                         default: 0,     null: false
    t.integer  "lock_version",                                default: 0,     null: false
    t.jsonb    "purchasers",                                  default: {},    null: false
    t.decimal  "price",               precision: 8, scale: 2
    t.decimal  "sale_price",          precision: 8, scale: 2
    t.boolean  "updated",                                     default: false, null: false
    t.boolean  "archived",                                    default: false, null: false
    t.boolean  "locked",                                      default: false, null: false
    t.jsonb    "ratings_ip",                                  default: {},    null: false
    t.jsonb    "likes_ip",                                    default: {},    null: false
    t.jsonb    "extras"
    t.string   "upload_url",                                  default: "",    null: false
    t.integer  "total_views",                                 default: 0,     null: false
    t.jsonb    "views",                                       default: {},    null: false
    t.integer  "user_views",                                  default: 0,     null: false
    t.integer  "guest_views",                                 default: 0,     null: false
    t.jsonb    "views_ip",                                    default: {},    null: false
    t.jsonb    "durations",                                   default: {},    null: false
    t.jsonb    "durations_ip",                                default: {},    null: false
    t.integer  "average_duration",                            default: 0,     null: false
    t.boolean  "user_viewed",                                 default: false, null: false
    t.integer  "unique_views",                                default: 0,     null: false
    t.boolean  "removed"
    t.jsonb    "old_properties",                              default: {}
    t.integer  "human_ratings",                               default: 0,     null: false
    t.integer  "human_ratings_count",                         default: 0,     null: false
    t.string   "uuid",                                        default: "",    null: false
    t.integer  "user_id"
    t.index "properties jsonb_path_ops", name: "products_properties_idx", using: :gin
    t.index ["created_at"], name: "index_product_on_created_at", using: :btree
    t.index ["hidden"], name: "index_product_on_hidden", using: :btree
    t.index ["sub_category"], name: "index_products_on_sub_category", using: :btree
    t.index ["tsv_body"], name: "index_products_on_tsv_body", using: :gin
    t.index ["url"], name: "index_product_on_url", using: :btree
    t.index ["user_id"], name: "index_themes_on_user_id", using: :btree
  end

  create_table "users", force: :cascade do |t|
    t.string   "firstname",              default: "", null: false
    t.string   "lastname",               default: "", null: false
    t.string   "email",                  default: "", null: false
    t.string   "encrypted_password",     default: "", null: false
    t.string   "reset_password_token"
    t.datetime "reset_password_sent_at"
    t.datetime "remember_created_at"
    t.integer  "sign_in_count",          default: 0,  null: false
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string   "current_sign_in_ip"
    t.string   "last_sign_in_ip"
    t.datetime "created_at",                          null: false
    t.datetime "updated_at",                          null: false
    t.boolean  "admin"
    t.string   "username"
    t.index ["email"], name: "index_users_on_email", unique: true, using: :btree
    t.index ["reset_password_token"], name: "index_users_on_reset_password_token", unique: true, using: :btree
  end

  add_foreign_key "orders", "themes"
  add_foreign_key "orders", "users"
  add_foreign_key "themes", "users"
end
