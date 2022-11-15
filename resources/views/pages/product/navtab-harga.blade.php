<select name="harga" id="harga"
    class="{{ request()->is('umum*') || request()->is('member*') || request()->is('grosir*') || request()->is('member-grosir*') ? 'text-white md:bg-[#f53b16] md:text-white p-3 bg-[#f53b16] hover:md:bg-white hover:md:text-black hover:bg-white hover:text-black' : 'md:text-black' }} block rounded py-2 pr-4 pl-3 text-white md:p-2">
    <option value="UMUM" @if (request()->is('umum*')) {{ 'selected' }} @endif>Harga
        Umum
    </option>
    <option value="MEMBER" @if (request()->is('member*')) {{ 'selected' }} @endif>Harga
        Member
    </option>
    <option value="GROSIR" @if (request()->is('grosir*')) {{ 'selected' }} @endif>Harga
        Grosir
    </option>
    <option value="MEMBER GROSIR" @if (request()->is('member-grosir*')) {{ 'selected' }} @endif>
        Harga Member Grosir</option>
</select>
