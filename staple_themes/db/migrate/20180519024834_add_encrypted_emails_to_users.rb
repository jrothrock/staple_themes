class AddEncryptedEmailsToUsers < ActiveRecord::Migration[5.1]
  def change
    add_column :users, :encrypted_email, :string
    add_column :users, :encrypted_email_iv, :string

    add_column :users, :encrypted_email_bidx, :string
    add_index :users, :encrypted_email_bidx, unique: true
    
    remove_column :users, :email, :string

    add_column :users, :compliance_agreement, :boolean, default:false
    add_column :users, :compliance_agreement_date, :datetime

    add_column :users, :email_agreement, :boolean, default:false
    add_column :users, :email_agreement_date, :datetime

    remove_column :users, :firstname, :string
    remove_column :users, :lastname, :string
  end
end
