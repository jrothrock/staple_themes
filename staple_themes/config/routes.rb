Rails.application.routes.draw do
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
  devise_for :users


  root to: "home#index"


  get 'users/:profile', to: 'profiles#read', as: :profile
  get 'users/:profile/purchases', to: 'orders#index', as: :purchases


  resources :themes do
  end
  post ':themes/new/upload', to:'themes#upload', as: :upload

end
