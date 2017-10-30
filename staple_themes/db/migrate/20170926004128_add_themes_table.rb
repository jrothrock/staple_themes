class AddThemesTable < ActiveRecord::Migration[5.0]
  def change
    create_table :themes do |t|
      t.string   "title",                                                         default: "",    null: false
      t.string   "category",                                                      default: "",    null: false
      t.string   "url",                                                           default: "",    null: false
      t.integer  "comment_count",                                                 default: 0,     null: false
      t.boolean  "hidden",                                                        default: false, null: false
      t.integer  "user_rated"
      t.integer  "average_rating",                                                default: 100,   null: false
      t.integer  "ratings_count",                                                 default: 0,     null: false
      t.jsonb     "ratings",                                                      default: {},    null: false
      t.text     "description"
      t.datetime "created_at",                                                                    null: false
      t.datetime "updated_at",                                                                    null: false
      t.jsonb    "properties",                                                    default: {},    null: false
      t.string   "sub_category",                                                  default: "",    null: false
      t.decimal  "shipping",                              precision: 8, scale: 2
      t.string   "shipping_type",                                                 default: "0",   null: false
      t.decimal  "tax",                                   precision: 8, scale: 2
      t.tsvector "tsv_body"
      t.text     "marked",                                                        default: "",    null: false
      t.text     "stripped",                                                      default: "",    null: false
      t.integer  "discount_percentage",                                           default: 0,     null: false
      t.integer  "lock_version",                                                  default: 0,     null: false
      t.jsonb    "purchasers",                                                    default: {},    null: false
      t.decimal  "price",                                 precision: 8, scale: 2
      t.decimal  "sale_price",                            precision: 8, scale: 2
      t.boolean  "updated",                                                       default: false, null: false
      t.boolean  "archived",                                                      default: false, null: false
      t.boolean  "locked",                                                        default: false, null: false
      t.jsonb    "ratings_ip",                                                    default: {},    null: false
      t.jsonb    "likes_ip",                                                      default: {},    null: false
      t.jsonb    "extras"
      t.string   "upload_url",                                                    default: '',    null: false
      t.integer  "total_views",                                                   default: 0,     null: false
      t.jsonb    "views",                                                         default: {},    null: false
      t.integer  "user_views",                                                    default: 0,     null: false
      t.integer  "guest_views",                                                   default: 0,     null: false
      t.jsonb    "views_ip",                                                      default: {},    null: false
      t.jsonb    "durations",                                                     default: {},    null: false
      t.jsonb    "durations_ip",                                                  default: {},    null: false
      t.integer  "average_duration",                                              default: 0,     null: false
      t.boolean  "user_viewed",                                                   default: false, null: false
      t.integer  "unique_views",                                                  default: 0,     null: false
      t.boolean  "removed"
      t.jsonb    "old_properties",                                                default: {}
      t.integer  "human_ratings",                               default: 0,     null: false
      t.integer  "human_ratings_count",                         default: 0,     null: false
      t.string   "uuid",                                                          default: "",    null: false
      t.index "properties jsonb_path_ops", name: "products_properties_idx", using: :gin
      t.index ["created_at"], name: "index_product_on_created_at", using: :btree
      t.index ["hidden"], name: "index_product_on_hidden", using: :btree
      t.index ["sub_category"], name: "index_products_on_sub_category", using: :btree
      t.index ["tsv_body"], name: "index_products_on_tsv_body", using: :gin
      t.index ["url"], name: "index_product_on_url", using: :btree
    end
  end
end


