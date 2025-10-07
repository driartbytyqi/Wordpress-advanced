    </div>

    <footer style="text-align:center; margin-top:40px; color:#888;">
        &copy; <?php echo date('Y'); ?> Personal Finance Tracker
    </footer>

    <!-- AI Chatbot Widget (Demo: ChatGPT Web Widget) -->
    <script>
    // Floating chat button
    const chatBtn = document.createElement('div');
    chatBtn.innerHTML = '💬';
    chatBtn.style.position = 'fixed';
    chatBtn.style.bottom = '32px';
    chatBtn.style.right = '32px';
    chatBtn.style.background = '#4f8cff';
    chatBtn.style.color = '#fff';
    chatBtn.style.width = '56px';
    chatBtn.style.height = '56px';
    chatBtn.style.borderRadius = '50%';
    chatBtn.style.display = 'flex';
    chatBtn.style.alignItems = 'center';
    chatBtn.style.justifyContent = 'center';
    chatBtn.style.fontSize = '2rem';
    chatBtn.style.cursor = 'pointer';
    chatBtn.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
    chatBtn.style.zIndex = '9999';
    document.body.appendChild(chatBtn);

    // Chat window
    const chatWindow = document.createElement('div');
    chatWindow.style.position = 'fixed';
    chatWindow.style.bottom = '100px';
    chatWindow.style.right = '32px';
    chatWindow.style.width = '350px';
    chatWindow.style.height = '420px';
    chatWindow.style.background = '#fff';
    chatWindow.style.borderRadius = '12px';
    chatWindow.style.boxShadow = '0 2px 16px rgba(0,0,0,0.18)';
    chatWindow.style.display = 'none';
    chatWindow.style.flexDirection = 'column';
    chatWindow.style.overflow = 'hidden';
    chatWindow.style.zIndex = '9999';
    // Replace 'your-chatbot-id' with your actual Chatbase chatbot ID
    chatWindow.innerHTML = `<iframe src="https://www.chatbase.co/chatbot-iframe/your-chatbot-id" style="width:100%;height:100%;border:none;"></iframe>`;
    document.body.appendChild(chatWindow);

    chatBtn.onclick = function() {
        chatWindow.style.display = chatWindow.style.display === 'none' ? 'flex' : 'none';
    };
    </script>
</body>
</html>
