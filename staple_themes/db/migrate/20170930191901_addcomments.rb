class Addcomments < ActiveRecord::Migration[5.0]
  def change
    create_table "comments", force: :cascade do |t|
      t.text     "body"
      t.integer  "generation"
      t.string   "submitted_by"
      t.datetime "created_at",                           null: false
      t.datetime "updated_at",                           null: false
      t.string   "commentable_type"
      t.integer  "upvotes",              default: 0,     null: false
      t.integer  "downvotes",            default: 0,     null: false
      t.integer  "average_vote",         default: 0,     null: false
      t.boolean  "edited",               default: false, null: false
      t.integer  "user_id"
      t.boolean  "flagged",              default: false, null: false
      t.boolean  "deleted",              default: false, null: false
      t.boolean  "flag_checked",         default: false, null: false
      t.string   "deleted_body"
      t.string   "deleted_submitted_by"
      t.string   "deleted_user_id"
      t.boolean  "hidden",               default: false, null: false
      t.boolean  "hide_proccessing",     default: false, null: false
      t.jsonb    "votes",                default: {},    null: false
      t.integer  "votes_count",          default: 0,     null: false
      t.text     "marked",               default: "",    null: false
      t.text     "stripped",             default: "",    null: false
      t.boolean  "notified",             default: false, null: false
      t.string   "category"
      t.string   "subcategory"
      t.string   "url"
      t.string   "post_type"
      t.string   "post_id"
      t.integer  "user_voted"
      t.string   "title"
      t.boolean  "admin",                default: false, null: false
      t.boolean  "seller",               default: false, null: false
      t.boolean  "submitter",            default: false, null: false
      t.string   "time_ago"
      t.boolean  "styled",               default: false, null: false
      t.boolean  "archived",             default: false, null: false
      t.integer  "karma_update",         default: 0,     null: false
      t.boolean  "voted",                default: false, null: false
      t.boolean  "removed",              default: false, null: false
      t.boolean  "locked",               default: false, null: false
      t.boolean  "stickied",             default: false, null: false
      t.jsonb    "votes_ip",             default: {},    null: false
      t.boolean  "checked",              default: false, null: false
      t.boolean  "reported",             default: false, null: false
      t.text     "report_users",         default: [],    null: false, array: true
      t.boolean  "user_reported",        default: false, null: false
      t.text     "report_types",         default: [],    null: false, array: true
      t.integer  "report_count",         default: 0,     null: false
      t.boolean  "report_checked",       default: false, null: false
      t.datetime "report_created"
      t.datetime "flag_created"
      t.jsonb    "human_votes",          default: {},    null: false
      t.integer  "human_votes_count",    default: 0,     null: false
      t.integer  "human_average_vote",   default: 0,     null: false
      t.integer  "human_upvotes",        default: 0,     null: false
      t.integer  "human_downvotes",      default: 0,     null: false
      t.string   "uuid",                 default: "",    null: false
      t.string   "commentable_uuid",     default: "",    null: false
      t.string   "parent_uuid",          default: ""
      t.index ["commentable_type", "commentable_uuid"], name: "index_comments_on_commentable_type_and_commentable_uuid", using: :btree
      t.index ["flag_checked"], name: "index_comments_on_flag_checked", using: :btree
      t.index ["flagged"], name: "index_comments_on_flagged", using: :btree
      t.index ["hidden"], name: "index_comments_on_hidden", using: :btree
      t.index ["submitted_by"], name: "index_comments_on_submitted_by", using: :btree
    end
  end
end
