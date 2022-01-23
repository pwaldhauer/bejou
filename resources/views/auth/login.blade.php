


<x-layout>

    <form action="/login" method="post">
        @csrf

        <div class="form-row">
            <input type="email" name="email" placeholder="E-Mail" />
        </div>

        <div class="form-row">
            <input type="password" name="password" placeholder="Password" />
        </div>

        <div class="form-row">
            <input type="submit" value="Submit" name="submit">
        </div>


    </form>

</x-layout>
