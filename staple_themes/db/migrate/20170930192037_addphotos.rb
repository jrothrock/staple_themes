class Addphotos < ActiveRecord::Migration[5.0]
  def change
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
  end
end
