Rails.application.routes.draw do
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
  devise_for :users


  root to: "home#index"


  get 'users/:profile', to: 'profiles#show', as: :profile
  get 'users/:profile/purchases', to: 'orders#index', as: :purchases


  resources :orders

  resources :themes do
    resources :comments
  end
  post ':themes/new/upload', to:'themes#upload', as: :upload
  get '/checkout', to:'checkout#show', as:'start_checkout'
  post '/checkout', to:'checkout#update', as:'new_purchase'
  post '/checkout/paypal', to:'checkout#paypal', as:'paypal_purchase'
end
