<x-guest-layout>
    @livewireStyles


    <section class="bg-blue-50 dark:bg-slate-800" id="contact">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="mb-4">
                <div class="mb-6 max-w-3xl text-center sm:text-center md:mx-auto md:mb-12">
                    <h2
                        class="font-heading mb-4 font-bold tracking-tight text-gray-900 dark:text-white text-3xl sm:text-5xl">
                        About Us
                    </h2>
                </div>
            </div>
            <div class="flex items-stretch justify-center">
                <div class="h-full">
                    <p class="mt-3 mb-12 text-lg text-justify text-gray-600 dark:text-slate-400">
                        PRIVATECH is a product of Merabow LLP a popular mobile device management application that allows
                        users to access and manage their Android devices from a computer or another mobile device. It
                        provides a range of features and functionalities to enhance the user experience and improve
                        device management.

                        <span class="font-semibold text-xl block pt-6 pb-3">
                            Here's some information about privatech:
                        </span>

                        <b>Remote Control:</b> privatech allows users to remotely control their Android devices from their
                        computers. They can access and interact with their device's screen, transfer files, and perform
                        various tasks without physically touching the device. <br><br>

                        <b>File Transfer:</b> Users can transfer files betweentheir Android devices and computers seamlessly
                        using privatech. It supports transferring various types of files, including documents, photos,
                        videos, and music. <br><br>

                        <b>Messaging and Notifications:</b> With privatech, users can send and receive SMS messages directly
                        from their computers. They can also receive app notifications, including social media updates,
                        calls, and messages, on their computer screens. <br><br>

                        <b>Phone Mirroring:</b> privatech enables users to mirror their Android device's screen onto their
                        computer, allowing them to view and interact with their device's interface on a larger display. <br><br>

                        <b>Find My Phone:</b> In case of a lost or misplaced device, privatech offers a "Find My Phone"
                        feature. It helps locate the device by making it ring at maximum volume, even if it is in silent
                        mode. Additionally, it provides the device's real-time location and allows users to lock or
                        erase their data remotely. <br><br>

                        <b>Device Management:</b> privatech allows users to manage various aspects of their Android devices,
                        including contacts, photos, videos,apps, and more, directly from their computer.It provides a
                        convenient way to organize andmaintain the content on the device. <br><br>

                        <b>Wireless Connectivity:</b> privatech establishes a wireless connection between the Android device
                        and the computer, eliminating the need for physical cables. Users can connect their devices and
                        computers to the same Wi-Fi network and access the device's content remotely. <br><br>

                        It's important to note that the features and functionalities offered by privatech may vary based
                        on the version and platform compatibility. It is always recommended to refer to the official
                        privatech website or documentation for the most up-to-date information and instructions on how
                        to use the application
                    </p>
                </div>
            </div>
        </div>
        </div>
    </section>

    @stack('modals')
    @livewireScripts
    @livewire('livewire-ui-modal')
</x-guest-layout>
