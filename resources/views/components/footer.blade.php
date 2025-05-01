<!-- Footer -->
<footer class="bg-blue-800 text-white grid md:grid-cols-3 gap-6 p-6">
    <div class="p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-2">About MOL</h3>
        <p class="text-sm">Mitsui O.S.K. Lines, as a social infrastructure company centered on the sea, sustaining people's lives and ensuring a prosperous future from the blue oceans.
This video describes outlines of our business activities and explains the MOL Group's common values "MOL CHARTS" and action plans to resolve sustainability issues "MOL Sustainability Plan".</p>
<br><a href="https://youtu.be/aSzyxL616Uk" class="text-sm" target="_blank">https://youtu.be/aSzyxL616Uk</a>
</p>
    </div>

    <div class="p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-2">Resources</h3>
        <ul class="text-sm space-y-1">
            <li><a href="#" class="hover:underline">Privacy Policy</a></li>
            <li><a href="#" class="hover:underline">Terms of Use</a></li>
            <li><a href="#" class="hover:underline">Contact Support</a></li>
        </ul>
    </div>

    <div class="p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-3">Contact Admin</h3>
        <form action="" method="POST" class="space-y-3">
            @csrf
            <input type="email" name="email" placeholder="Your Email" class="w-full p-2 rounded border" required>
            <textarea name="message" rows="3" placeholder="Your Message" class="w-full p-2 rounded border resize-none" required></textarea>
            <button type="submit" class="w-full bg-white text-[#5147E3] font-semibold py-2 rounded hover:bg-gray-200 transition">Send</button>
        </form>
    </div>
</footer>
