<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
        <div class="max-w-3xl w-full">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Decorative Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-8 px-6 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
                    <p class="text-indigo-100 mt-2">Sign in to your Vistana account</p>
                </div>

                <!-- Form Container -->
                <div class="p-8">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-6">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                            </div>
                            <div class="relative">
                                <x-text-input 
                                    id="email" 
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    placeholder="Enter your email address" 
                                />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                            </div>
                            <div class="relative">
                                <x-text-input 
                                    id="password" 
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-8">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                <div class="relative">
                                    <input id="remember_me" type="checkbox" class="sr-only" name="remember">
                                    <div class="w-5 h-5 border border-gray-300 rounded-md flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white hidden check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <span class="ms-3 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>

                            {{-- @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors duration-200" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif --}}
                        </div>

                        <!-- Login Button -->
                        <div class="mb-6">
                            <x-primary-button class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Sign In') }}
                            </x-primary-button>
                        </div>

                        <!-- Divider -->
                        <div class="relative mb-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Or continue with</span>
                            </div>
                        </div>

                        <!-- Social Login -->
                        <div class="mb-6">
                            <a href="{{ route('login.provider', 'google') }}" 
                               class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 hover:bg-gray-50 hover:shadow-md transition-all duration-200">
                                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span class="font-medium">Continue with Google</span>
                            </a>
                        </div>
                    </form>

                    <!-- Footer Links -->
                    {{-- <div class="text-center pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-800 ml-1 transition-colors duration-200">
                                    {{ __('Create account') }}
                                </a>
                            @endif
                        </p>
                    </div> --}}
                </div>
            </div>

            <!-- App Info -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-600">
                    © {{ date('Y') }} Vistana Hotel Management. All rights reserved.
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    Secure login powered by Laravel Authentication
                </p>
            </div>
        </div>
    </div>

    <style>
        .check-icon {
            transition: all 0.2s ease;
        }
        
        input:checked + div .check-icon {
            display: block;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            border: none;
        }
        
        input:checked + div {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            border: none;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }
        
        .hover\:shadow-xl:hover {
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
        }
        
        /* Smooth transitions */
        input, button, a {
            transition: all 0.2s ease-in-out;
        }
        
        /* Focus styles */
        input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        /* Custom checkbox */
        .sr-only + div {
            transition: all 0.2s ease;
        }
        
        .sr-only:checked + div {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-color: transparent;
        }
    </style>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
        
        // Custom checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const rememberCheckbox = document.getElementById('remember_me');
            const checkDiv = rememberCheckbox.nextElementSibling;
            
            rememberCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    checkDiv.innerHTML = `
                        <svg class="w-3 h-3 text-white check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    `;
                    checkDiv.style.background = 'linear-gradient(135deg, #4f46e5, #7c3aed)';
                    checkDiv.style.borderColor = 'transparent';
                } else {
                    checkDiv.innerHTML = '';
                    checkDiv.style.background = 'transparent';
                    checkDiv.style.borderColor = '#d1d5db';
                }
            });
            
            // Initialize checkbox state
            if (rememberCheckbox.checked) {
                checkDiv.innerHTML = `
                    <svg class="w-3 h-3 text-white check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                `;
                checkDiv.style.background = 'linear-gradient(135deg, #4f46e5, #7c3aed)';
                checkDiv.style.borderColor = 'transparent';
            }
        });
        
        // Add floating label animation
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('ring-2', 'ring-indigo-500');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('ring-2', 'ring-indigo-500');
            });
        });
    </script>
</x-guest-layout>