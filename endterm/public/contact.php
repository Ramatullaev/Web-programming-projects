<?php $pageTitle = 'Contact — Eventify'; include dirname(__DIR__) . '/includes/header.php'; ?>
<section class="section">
  <div class="container">
    <h2>Contact Us</h2>
    <p class="mt-2">Have questions about registration, routes, or volunteering? Reach out.</p>
    <div class="grid mt-3" style="grid-template-columns: 2fr 3fr; gap: 16px;">
      <div class="card"><div class="content">
        <p><strong>Email:</strong> support@eventify.local</p>
        <p><strong>Phone:</strong> +7 (777) 000-00-00</p>
        <p><strong>Address:</strong> Алматы, площадь Республики</p>
      </div></div>
      <div>
        <form id="contact-form">
          <div>
            <label for="cname">Your name</label>
            <input id="cname" name="name" required>
          </div>
          <div>
            <label for="cemail">Email</label>
            <input id="cemail" name="email" type="email" required>
          </div>
          <div>
            <label for="cmsg">Message</label>
            <textarea id="cmsg" name="message" rows="4" required style="width: 100%; padding: 10px; border-radius: 6px; background: #0b1224; border: 1px solid #1f2937; color: var(--text);"></textarea>
          </div>
          <button type="submit">Send</button>
        </form>
        <div id="contact-message" style="margin-top: 12px;"></div>
        
        <script>
        // Enhanced message display with Scriptaculous effects
        function showContactMessage(text, type) {
          const container = document.getElementById('contact-message');
          container.innerHTML = '';
          const message = document.createElement('div');
          message.id = 'contact-msg-' + Date.now();
          message.textContent = text;
          message.style.padding = '12px';
          message.style.borderRadius = '8px';
          message.style.marginTop = '12px';
          
          if (type === 'success') {
            message.style.background = '#1f2937';
            message.style.color = '#22d3ee';
            message.style.border = '1px solid #22d3ee';
          } else if (type === 'info') {
            message.style.background = '#1f2937';
            message.style.color = '#9ca3af';
            message.style.border = '1px solid #4b5563';
          } else {
            message.style.background = '#1f2937';
            message.style.color = '#ef4444';
            message.style.border = '1px solid #ef4444';
          }
          
          container.appendChild(message);
          
          // Use Scriptaculous if available
          if (typeof Effect !== 'undefined') {
            message.style.display = 'none';
            new Effect.Appear(message.id, { duration: 0.5 });
            if (type === 'success') {
              setTimeout(() => {
                new Effect.Fade(message.id, { duration: 0.5 });
              }, 4000);
            }
          }
        }
        </script>
      </div>
      
      <script>
      document.getElementById('contact-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const messageContainer = document.getElementById('contact-message');
        
        const formData = {
          action: 'comment',
          name: form.cname.value,
          email: form.cemail.value,
          message: form.cmsg.value
        };
        
        // Show loading message
        showContactMessage('Sending message...', 'info');
        
        try {
          const result = await postComment(formData);
          
          if (result.success) {
            showContactMessage('Message sent successfully! We will get back to you soon.', 'success');
            form.reset();
          } else {
            showContactMessage('Error: ' + (result.error || 'Failed to send message'), 'error');
          }
        } catch (error) {
          showContactMessage('Network error. Please try again.', 'error');
        }
      });
      </script>
    </div>
  </div>
</section>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


