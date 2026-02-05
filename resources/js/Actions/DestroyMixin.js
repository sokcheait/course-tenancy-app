import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import Swal from 'sweetalert2'

export default function DestroyMixin() {

    const toast = useToast()

    const destroy = (url, text = "You won't be able to revert this!") => {
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {
                router.delete(url, {
                    preserveScroll: true,

                    onSuccess: () => {
                        toast.success('Deleted successfully')
                    },

                    onError: () => {
                        toast.error('Delete failed')
                    }
                })
            }

        })
    }

    return { destroy }
}