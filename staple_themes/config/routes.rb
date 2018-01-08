require 'sidekiq/web'
Rails.application.routes.draw do
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
  mount Sidekiq::Web => '/sidekiq'
  devise_for :users, :controllers => {sessions: 'sessions', registrations: 'registrations'}

  root to: "home#index"


  get '/users/:profile', to: 'profiles#show', as: :profile
  get '/users/:profile/purchases', to: 'orders#index', as: :purchases


  resources :orders

  resources :themes do
    resources :comments
  end
  get '/themes/:id/download', to:'themes#download', as:"download_theme"
  post '/themes/new/upload', to:'themes#upload', as: :upload
  get '/checkout', to:'checkout#show', as:'start_checkout'
  get '/contact', to: 'contact#new', as:'contact'
  post '/contact', to: 'contact#create', as:"create_contact"
  get '/terms', to: 'terms#terms', as:"terms"
  get '/privacy', to: 'terms#privacy', as:'privacy'
  get '/cookies', to: 'terms#cookies', as:'cookies'
  post '/checkout', to:'checkout#update', as:'new_purchase'
  post '/checkout/paypal', to:'checkout#paypal', as:'paypal_purchase'
end
