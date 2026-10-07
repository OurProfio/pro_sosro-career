<div id="stage-email-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto overflow-x-hidden bg-black/40 p-4">

    <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="relative bg-white rounded-2xl shadow-xl">

            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">
                        Data Tahapan Applicant
                    </h3>

                    <p class="mt-1 text-xs text-slate-500">
                        Lengkapi data yang dibutuhkan untuk tahapan ini.
                    </p>
                </div>

                <button type="button" data-modal-hide="stage-email-modal"
                    class="inline-flex items-center justify-center w-9 h-9 text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-600 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('sendEmail') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="application_id" id="modal-application-id">
                <input type="hidden" name="stages_id" id="modal-stage-id">

                <div class="px-6 py-6 space-y-5">

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                        <p class="text-xs text-slate-400 mb-1">
                            Applicant
                        </p>

                        <p id="modal-applicant-name" class="text-sm font-semibold text-slate-800">
                            -
                        </p>

                        <p id="modal-applicant-email" class="text-xs text-slate-500 mt-1">
                            -
                        </p>
                    </div>

                    <div>
                        <label for="modal-stage-name" class="block mb-2 text-sm font-semibold text-slate-700">
                            Stage
                        </label>

                        <input type="text" id="modal-stage-name"
                            class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700"
                            readonly>
                    </div>

                    <div id="stage-fields">

                        <div id="fields-psikotes" class="stage-fields hidden space-y-4">

                            <div>
                                <label for="psikotes_link" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Link Psikotes
                                </label>

                                <input type="url" name="psikotes_link" id="psikotes_link" placeholder="https://..."
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            </div>

                            <div>
                                <label for="psikotes_code" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Kode Psikotes
                                </label>

                                <input type="text" name="psikotes_code" id="psikotes_code"
                                    placeholder="Masukkan kode psikotes"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            </div>

                        </div>

                        <div id="fields-interview" class="stage-fields hidden space-y-4">

                            <div>
                                <label for="interview_type" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Metode Interview
                                </label>

                                <select name="interview_type" id="interview_type"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                    <option value="virtual">
                                        Virtual
                                    </option>

                                    <option value="offline">
                                        Offline
                                    </option>
                                </select>
                            </div>

                            <div id="interview-virtual-field">

                                <label for="interview_link" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Link GMeet / Zoom
                                </label>

                                <input type="url" name="interview_link" id="interview_link"
                                    placeholder="https://meet.google.com/..."
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">

                            </div>

                            <div id="interview-offline-field" class="hidden">

                                <label for="interview_address" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Alamat Interview
                                </label>

                                <textarea name="interview_address" id="interview_address" rows="3" placeholder="Masukkan alamat interview"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></textarea>

                            </div>

                        </div>

                        <div id="fields-mcu" class="stage-fields hidden">

                            <label for="mcu_address" class="block mb-2 text-sm font-semibold text-slate-700">
                                Alamat RS / Klinik
                            </label>

                            <textarea name="mcu_address" id="mcu_address" rows="3" placeholder="Masukkan alamat RS / Klinik"
                                class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></textarea>

                        </div>

                        <div id="fields-study-case" class="stage-fields hidden space-y-4">

                            <div>
                                <label for="study_case_file" class="block mb-2 text-sm font-semibold text-slate-700">
                                    File Materi Study Case
                                </label>

                                <input type="file" name="study_case_file" id="study_case_file" accept=".pdf"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600">
                            </div>

                            <div>
                                <label for="study_case_link" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Link Google Drive
                                </label>

                                <input type="url" name="study_case_link" id="study_case_link"
                                    placeholder="https://drive.google.com/..."
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            </div>

                        </div>

                        <div id="fields-panel-bod" class="stage-fields hidden space-y-4">

                            <div>
                                <label for="panel_bod_type" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Metode Interview
                                </label>

                                <select name="panel_bod_type" id="panel_bod_type"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                    <option value="virtual">
                                        Virtual
                                    </option>

                                    <option value="offline">
                                        Offline
                                    </option>
                                </select>
                            </div>

                            <div id="panel-bod-virtual-field">

                                <label for="panel_bod_link" class="block mb-2 text-sm font-semibold text-slate-700">
                                    Link GMeet / Zoom
                                </label>

                                <input type="url" name="panel_bod_link" id="panel_bod_link"
                                    placeholder="https://meet.google.com/..."
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">

                            </div>

                            <div id="panel-bod-offline-field" class="hidden">

                                <label for="panel_bod_address"
                                    class="block mb-2 text-sm font-semibold text-slate-700">
                                    Alamat Interview
                                </label>

                                <textarea name="panel_bod_address" id="panel_bod_address" rows="3" placeholder="Masukkan alamat interview"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></textarea>

                            </div>

                        </div>

                        <div id="fields-none" class="stage-fields hidden">

                            <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                                <p class="text-sm text-slate-600">
                                    Tahapan ini tidak membutuhkan input tambahan.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200">

                    <button type="button" data-modal-hide="stage-email-modal"
                        class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                        Lanjutkan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
