from django.shortcuts import render


# Create your views here.
def index(request):
    return render(request, 'modelfabrik/index.html')


def room(request, room_name):
    return render(request, 'modelfabrik/room.html', {
        'room_name': room_name
    })


def startpage(request):
    return render(request, 'modelfabrik/startpage.html')
