  @php
    $settings_details = getGeneralSettingsDetails(); 
  @endphp

  <!-- Footer Start -->
  <footer class="footer mt-auto py-3 bg-white text-center">
      <div class="container">
          <span class="text-muted"> <span id="year"></span> {!! xss_clean($settings_details['copyright_text']) !!}</span>
      </div>
  </footer>
  <!-- Footer End -->
