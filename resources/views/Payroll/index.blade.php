<form method="POST" action="/payday/calculate">
    @csrf
    <input name="year" type="text" placeholder="year" />
    <input name="month" type="text" placeholder="month" />
    <input type="submit" />
</form>