class Discount < ApplicationRecord
    validates_numericality_of :amount, :less_than_or_equal_to => 1
end