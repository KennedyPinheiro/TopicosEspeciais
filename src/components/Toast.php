<?php
/**
 * Componente Toast para exibição de mensagens
 */
function Toast($config = []) {
    $type = $config['type'] ?? 'error'; // error, success, warning, info
    $message = $config['message'] ?? '';
    $duration = $config['duration'] ?? 5000;
    $position = $config['position'] ?? 'top-right'; // top-right, top-left, bottom-right, bottom-left
    
    if (empty($message)) {
        return '';
    }
    
    $icons = [
        'error' => 'mdi:alert-circle',
        'success' => 'mdi:check-circle',
        'warning' => 'mdi:alert',
        'info' => 'mdi:information'
    ];
    
    $colors = [
        'error' => '#dc2626',
        'success' => '#16a34a',
        'warning' => '#d97706',
        'info' => '#2563eb'
    ];
    
    $icon = $icons[$type] ?? $icons['error'];
    $color = $colors[$type] ?? $colors['error'];
    
    return <<<'HTML'
    <div class='toast-container {$position}' data-type='{$type}'>
        <div class='toast-alert' style='--toast-color: {$color};' data-duration='{$duration}'>
            <div class='toast-icon'>
                <span class='iconify' data-icon='{$icon}' data-width='20' data-height='20'></span>
            </div>
            <div class='toast-content'>
                <div class='toast-message'>{$message}</div>
            </div>
            <button class='toast-close' onclick='this.parentElement.remove()'>
                <span class='iconify' data-icon='mdi:close' data-width='16' data-height='16'></span>
            </button>
        </div>
    </div>
    <style>
        .toast-container {
            position: fixed;
            z-index: 9999;
            padding: 1rem;
            pointer-events: none;
        }
        
        .toast-container.top-right {
            top: 0;
            right: 0;
        }
        
        .toast-container.top-left {
            top: 0;
            left: 0;
        }
        
        .toast-container.bottom-right {
            bottom: 0;
            right: 0;
        }
        
        .toast-container.bottom-left {
            bottom: 0;
            left: 0;
        }
        
        .toast-alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: white;
            border-left: 4px solid var(--toast-color);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            margin-bottom: 0.75rem;
            pointer-events: all;
            animation: toastSlideIn 0.3s ease-out;
            max-width: 400px;
            min-width: 300px;
        }
        
        .toast-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            color: var(--toast-color);
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-message {
            color: #1f2937;
            font-weight: 500;
            font-size: 0.95rem;
            line-height: 1.4;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toast-close:hover {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        @keyframes toastSlideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes toastSlideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .toast-alert.hiding {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        
        @media (max-width: 768px) {
            .toast-container {
                padding: 0.75rem;
            }
            
            .toast-alert {
                min-width: 280px;
                max-width: calc(100vw - 1.5rem);
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toast-alert').forEach(toast => {
                const duration = parseInt(toast.getAttribute('data-duration'));
                setTimeout(() => {
                    toast.classList.add('hiding');
                    setTimeout(() => toast.remove(), 300);
                }, duration);
            });
            
            window.showToast = function(config) {
                const {
                    type = 'error',
                    message = '',
                    duration = 5000,
                    position = 'top-right'
                } = config || {};
                
                if (!message) return;
                
                const toastHTML = generateToastHTML(type, message, duration, position);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = toastHTML;
                const toastElement = tempDiv.firstElementChild;
                
                document.body.appendChild(toastElement);
                
                setTimeout(() => {
                    const alert = toastElement.querySelector('.toast-alert');
                    if (alert) {
                        alert.classList.add('hiding');
                    }
                    setTimeout(() => toastElement.remove(), 300);
                }, duration);
            };
        });
        
        function generateToastHTML(type, message, duration, position) {
            const icons = {
                'error': 'mdi:alert-circle',
                'success': 'mdi:check-circle',
                'warning': 'mdi:alert',
                'info': 'mdi:information'
            };
            
            const colors = {
                'error': '#dc2626',
                'success': '#16a34a',
                'warning': '#d97706',
                'info': '#2563eb'
            };
            
            const icon = icons[type] || icons.error;
            const color = colors[type] || colors.error;
            
            return `
            <div class="toast-container ${position}" data-type="${type}">
                <div class="toast-alert" style="--toast-color: ${color}" data-duration="${duration}">
                    <div class="toast-icon">
                        <span class="iconify" data-icon="${icon}" data-width="20" data-height="20"></span>
                    </div>
                    <div class="toast-content">
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="this.parentElement.remove();">
                        <span class="iconify" data-icon="mdi:close" data-width="16" data-height="16"></span>
                    </button>
                </div>
            </div>
            `;
        }
    </script>
HTML;
}
?>