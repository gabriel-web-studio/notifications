<div class="w-72 bg-black bg-opacity-25 rounded shadow-md p-2 transform transition-all duration-500 ease-in-out">
    <div class="flex justify-between">
        <span class="font-bold">
            <i class="fad {{ $notificationManager->icons[$notification[0]] }} mr-2"></i>
            {{ $notification[1] }}
        </span>
        <i class="fad fa-times hover:text-red-500 cursor-pointer" onclick="removeNotification(this)"></i>
    </div>
    @if(count($notification) === 3)
        <p class="mt-2 text-justify">{{ $notification[2] }}</p>
    @endif
</div>

