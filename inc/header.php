<nav class="bg-blue-600 text-white p-4 shadow">
    <ul class="flex justify-around">
        <?php if ($user -> getRole() == 'admin'): ?>
            <li><a href="/pages/admin/add_car.php" class="hover:text-gray-200">Add Cars</a></li>
            <li><a href="/pages/admin/view_users.php" class="hover:text-gray-200">View Users</a></li>
            <li><a href="/pages/admin/view_rental_contracts.php" class="hover:text-gray-200">View Contracts</a></li>
        <?php endif ?>
        <li><a href="/pages/user/view_cars.php" class="hover:text-gray-200">View Cars</a></li>
        <li><a href="/pages/user/add_rental_contract.php" class="hover:text-gray-200">Add a Contract</a></li>
        <li><a href="/pages/user/view_my_rental_contracts.php" class="hover:text-gray-200">My Contracts</a></li>
        <li><a href="/pages/user/profile.php" class="hover:text-gray-200">Profile</a></li>
        <li><a href="/auth/logout.php" class="hover:text-gray-200">Logout</a></li>
    </ul>
</nav>