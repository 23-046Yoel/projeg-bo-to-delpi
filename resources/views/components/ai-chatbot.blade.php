<div x-data="aiChatBot()" class="fixed bottom-6 right-6 z-[9999]">
    <!-- Floating Button -->
    <button @click="toggleChat()" 
            class="group relative w-16 h-16 bg-gradient-to-tr from-royal-navy to-indigo-600 rounded-2xl shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group">
        <div class="absolute -top-1 -right-1 w-4 h-4 bg-gold rounded-full border-2 border-white animate-pulse"></div>
        <!-- AI Sparkles/Brain Icon -->
        <svg class="w-8 h-8 text-white transition-transform duration-500" :class="isOpen ? 'rotate-90 scale-0' : 'group-hover:rotate-12'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
        <!-- Close Icon -->
        <svg class="absolute w-8 h-8 text-white transition-transform duration-500" :class="isOpen ? 'rotate-0 scale-100' : '-rotate-90 scale-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="absolute bottom-20 right-0 w-[22rem] sm:w-[26rem] bg-white rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] border border-gray-100 overflow-hidden flex flex-col max-h-[80vh]">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-royal-navy to-indigo-700 p-6 flex items-center gap-4">
            <div class="relative w-12 h-12 rounded-full bg-white/20 p-2 border-2 border-white/50 shadow-inner">
                <svg class="w-full h-full text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-royal-navy shadow-sm"></div>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg tracking-tight">BoTo Delphi</h3>
                <p class="text-indigo-100/60 text-[10px] font-black uppercase tracking-widest">Active • Ready to assist</p>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-contents" class="flex-1 p-6 overflow-y-auto bg-silk/30 space-y-4 max-h-[50vh]">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.isAi ? 'flex justify-start' : 'flex justify-end pr-2'">
                    <div :class="msg.isAi 
                        ? 'bg-white rounded-tr-2xl rounded-br-2xl rounded-bl-2xl shadow-md max-w-[85%] p-4 text-gray-800 border border-gray-100' 
                        : 'bg-royal-navy rounded-tl-2xl rounded-br-2xl rounded-bl-2xl shadow-lg max-w-[85%] p-4 text-white'"
                         class="relative">
                        <p class="text-sm leading-relaxed" x-text="msg.text"></p>
                        <span class="block text-[9px] mt-2 text-right" :class="msg.isAi ? 'text-gray-400 font-bold' : 'text-indigo-200 font-bold'" x-text="msg.time"></span>
                    </div>
                </div>
            </template>
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white rounded-tr-2xl rounded-br-2xl rounded-bl-2xl shadow-md p-4 flex gap-1 border border-gray-100">
                    <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                    <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-100 flex items-center gap-2">
            <input type="text" 
                   x-model="userInput" 
                   @keydown.enter="sendMessage"
                   placeholder="Ask about inventory or reports..." 
                   class="flex-1 bg-gray-50 border border-gray-200 rounded-full px-6 py-3 text-sm focus:ring-2 focus:ring-royal-navy focus:border-transparent outline-none transition-all">
            <button @click="sendMessage" 
                    :disabled="!userInput.trim() || isTyping"
                    class="w-12 h-12 bg-royal-navy text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 active:scale-95 transition-all disabled:opacity-50 disabled:hover:scale-100">
                <svg class="w-5 h-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
function aiChatBot() {
    return {
        isOpen: false,
        userInput: '',
        isTyping: false,
        messages: [
            { isAi: true, text: 'Halo! Saya asisten AI BoTo Delphi. Ada yang bisa saya bantu terkait stok barang atau laporan hari ini?', time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }
        ],
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                setTimeout(() => this.scrollToBottom(), 100);
            }
        },
        async sendMessage() {
            if (!this.userInput.trim()) return;

            const text = this.userInput;
            this.userInput = '';
            
            this.messages.push({
                isAi: false,
                text: text,
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            });

            this.scrollToBottom();
            this.isTyping = true;

            try {
                const response = await fetch('{{ route("chat.query") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                
                this.messages.push({
                    isAi: true,
                    text: data.reply || 'Maaf, saya sedang kesulitan memproses jawaban.',
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                });

            } catch (error) {
                this.messages.push({
                    isAi: true,
                    text: 'Terjadi kesalahan koneksi.',
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },
        scrollToBottom() {
            const container = document.getElementById('chat-contents');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
    }
}
</script>
