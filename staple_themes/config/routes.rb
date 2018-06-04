require 'sidekiq/web'
Rails.application.routes.draw do
  mount Ckeditor::Engine => '/ckeditor'
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
  mount Sidekiq::Web => '/sidekiq'
  devise_for :users, :controllers => {sessions: 'sessions', registrations: 'registrations'}

  root to: "home#index"

  resources :posts, path: 'blog' do
    resources :comments
  end
  post '/blog/:id/likes', to:'posts#likes', as: 'like_post'

  get '/users/reset', to: 'reset#show', as:'reset_password'
  post '/users/reset', to: 'reset#create', as:'create_reset_password'
  get '/users/reset/confirm', to:'reset#update', as:'confirm_reset_password'
  post '/users/reset/confirm', to: 'reset#update_password', as:'update_reset_password'

  get '/users/:profile', to: 'profiles#show', as: :profile
  get '/users/:profile/purchases', to: 'orders#index', as: :purchases

  resources :hosting

  resources :discounts

  resources :orders
  post "/orders/:id/discount", to:'orders#discount', as:"discount_order"
  
  resources :themes do
    resources :comments
  end

  get '/themes/:id/download', to:'themes#download', as:"download_theme"
  post '/themes/new/upload', to:'themes#upload', as: :upload
  post '/themes/:id/edit/upload', to: 'themes#upload', as:"edit_upload"

  get '/contact', to: 'contact#new', as:'contact'
  post '/contact', to: 'contact#create', as:"create_contact"

  get '/terms', to: 'terms#terms', as:"terms"
  get '/privacy', to: 'terms#privacy', as:'privacy'
  get '/cookies', to: 'terms#cookies', as:'cookies'

  get '/checkout', to:'checkout#show', as:'start_checkout'
  post '/checkout', to:'checkout#update', as:'new_purchase'
  post '/checkout/paypal', to:'checkout#paypal', as:'paypal_purchase'
end