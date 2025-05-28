@auth
    <!-- Estilos para el sistema de XP -->
    <style>
        .xbox-xp-notification {
            position: fixed;
            top: 50px;
            right: -400px;
            width: 350px;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            border-radius: 10px;
            padding: 20px;
            z-index: 9999;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            backdrop-filter: blur(5px);
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.2);
            opacity: 0;
        }

        .xbox-xp-notification.show {
            right: 20px;
            opacity: 1;
        }

        .xbox-xp-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .xbox-xp-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00ff00, #008000);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            animation: pulse 2s infinite;
        }

        .xbox-xp-details {
            flex-grow: 1;
        }

        .xbox-xp-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #00ff00;
        }

        .xbox-xp-description {
            font-size: 14px;
            margin: 5px 0 0;
            opacity: 0.8;
        }

        .xbox-progress-bar {
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            margin-top: 10px;
            overflow: hidden;
        }

        .xbox-progress-fill {
            height: 100%;
            background: #00ff00;
            width: 0%;
            transition: width 1s ease;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 255, 0, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(0, 255, 0, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 255, 0, 0);
            }
        }

        /* Botón flotante estilo Xbox */
        .xbox-floating-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #107C10, #0B5C0B);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1050;
            box-shadow: 0 4px 15px rgba(16, 124, 16, 0.3);
        }

        .xbox-floating-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(16, 124, 16, 0.4);
        }

        .xbox-floating-button i {
            color: white;
            font-size: 24px;
        }

        /* Panel lateral estilo Xbox */
        .xbox-sidebar {
            position: fixed;
            right: -400px;
            top: 0;
            width: 400px;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.5s cubic-bezier(0.7, 0, 0.3, 1);
            z-index: 1060;
            padding: 30px;
            color: white;
            overflow-y: auto;
        }

        .xbox-sidebar.show {
            right: 0;
        }

        .xbox-achievement {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transform: translateX(50px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .xbox-achievement.show {
            transform: translateX(0);
            opacity: 1;
        }

        .xbox-close-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .xbox-close-button:hover {
            transform: rotate(90deg);
        }
    </style>

    <!-- Botón flotante estilo Xbox -->
    <div class="xbox-floating-button" id="xboxXPButton">
        <i class="bi bi-trophy-fill"></i>
    </div>

    <!-- Panel lateral estilo Xbox -->
    <div class="xbox-sidebar" id="xboxSidebar">
        <button class="xbox-close-button" id="xboxCloseButton">
            <i class="bi bi-x"></i>
        </button>
        
        <h3 class="mb-4" style="color: #107C10">Mi Progreso</h3>
        
        <!-- Nivel actual -->
        <div class="xbox-achievement show" style="background: linear-gradient(135deg, rgba(16, 124, 16, 0.2), rgba(16, 124, 16, 0.1))">
            <div class="d-flex align-items-center gap-3">
                <div class="xbox-xp-icon">
                    {{ $currentLevel ? $currentLevel->level_number : 1 }}
                </div>
                <div>
                    <h4 class="mb-0" style="color: #107C10">Nivel {{ $currentLevel ? $currentLevel->level_number : 1 }}</h4>
                    <p class="mb-0 text-white-50">{{ number_format($totalXP) }} XP Total</p>
                </div>
            </div>
            <div class="xbox-progress-bar mt-3">
                <div class="xbox-progress-fill" style="width: {{ $progressToNext }}%"></div>
            </div>
        </div>

        <!-- Últimos logros -->
        <h5 class="mt-4 mb-3 text-white-50">Últimos Logros</h5>
        @forelse($unlockedAchievements as $index => $achievement)
            <div class="xbox-achievement" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="d-flex align-items-center gap-3">
                    <div class="xbox-xp-icon">
                        {!! $achievement->icon !!}
                    </div>
                    <div>
                        <h6 class="mb-0" style="color: #107C10">{{ $achievement->title }}</h6>
                        <small class="text-white-50">+{{ $achievement->xp_reward }} XP</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="xbox-achievement show">
                <p class="text-white-50 mb-0">Aún no has desbloqueado ningún logro</p>
            </div>
        @endforelse

        <a href="{{ route('perfil.xp') }}" class="btn w-100 mt-4" 
           style="background: #107C10; color: white; border: none;">
            Ver todos mis logros
        </a>
    </div>

    <!-- Notificación estilo Xbox -->
    <div class="xbox-xp-notification" id="xboxNotification">
        <div class="xbox-xp-content">
            <div class="xbox-xp-icon">
                <i class="bi bi-trophy-fill"></i>
            </div>
            <div class="xbox-xp-details">
                <p class="xbox-xp-title">¡Logro Desbloqueado!</p>
                <p class="xbox-xp-description" id="achievementText"></p>
            </div>
        </div>
        <div class="xbox-progress-bar">
            <div class="xbox-progress-fill"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const xboxButton = document.getElementById('xboxXPButton');
            const xboxSidebar = document.getElementById('xboxSidebar');
            const xboxCloseButton = document.getElementById('xboxCloseButton');
            const achievements = document.querySelectorAll('.xbox-achievement');

            // Mostrar el panel lateral
            xboxButton.addEventListener('click', function() {
                xboxSidebar.classList.add('show');
                // Animar los logros secuencialmente
                achievements.forEach((achievement, index) => {
                    setTimeout(() => {
                        achievement.classList.add('show');
                    }, index * 100);
                });
            });

            // Cerrar el panel lateral
            xboxCloseButton.addEventListener('click', function() {
                xboxSidebar.classList.remove('show');
                // Resetear las animaciones de los logros
                achievements.forEach(achievement => {
                    achievement.classList.remove('show');
                });
            });

            // Función para mostrar notificación de logro
            window.showXboxAchievement = function(title, xp) {
                const notification = document.getElementById('xboxNotification');
                const progressFill = notification.querySelector('.xbox-progress-fill');
                document.getElementById('achievementText').textContent = title + ' (+' + xp + ' XP)';
                
                notification.classList.add('show');
                progressFill.style.width = '100%';

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        progressFill.style.width = '0%';
                    }, 500);
                }, 4000);
            };

            // Ejemplo de uso:
            // showXboxAchievement('¡Primer Cuestionario Perfecto!', 100);
        });
    </script>
@else
    <!-- Modal para usuarios no autenticados -->
    <div class="xbox-floating-button" data-bs-toggle="modal" data-bs-target="#xboxRegisterModal">
        <i class="bi bi-trophy-fill"></i>
    </div>

    <div class="modal fade" id="xboxRegisterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title">¡Únete a la aventura!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="xbox-xp-icon mx-auto mb-3">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h4 class="mb-3" style="color: #107C10">Desbloquea tu potencial</h4>
                    <p class="mb-4">Regístrate para comenzar a ganar XP y desbloquear logros mientras aprendes.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('signin') }}" class="btn btn-success">Registrarme ahora</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Ya tengo cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endauth 